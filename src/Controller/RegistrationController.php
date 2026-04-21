<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator; // 🚀 IMPORTANT : Import de ton Authenticator
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface; // 🚀 IMPORTANT : Pour l'auto-login

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        UserAuthenticatorInterface $userAuthenticator, // 👈 Ajouté
        AppAuthenticator $authenticator,               // 👈 Ajouté
        EntityManagerInterface $entityManager
    ): Response {
        $user = new Utilisateur();
        // ON AJOUTE LA DATE D'INSCRIPTION ICI AUTOMATIQUEMENT
        $user->setDateInscription(new \DateTime());

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hachage du mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // 🚀 MODIFICATION ICI : On connecte l'utilisateur automatiquement
            // Une fois connecté, il sera redirigé selon ce qui est écrit dans ton AppAuthenticator
            // (qui redirige normalement vers 'app_etagere' comme on l'a configuré ensemble)
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}