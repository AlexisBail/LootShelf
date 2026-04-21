<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
// 🚀 Import indispensable pour lier le bon limiteur
use Symfony\Component\DependencyInjection\Attribute\Autowire; 

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        UserAuthenticatorInterface $userAuthenticator, 
        AppAuthenticator $authenticator, 
        EntityManagerInterface $entityManager,
        
        // 🛡️ On force l'injection du service spécifique "limiter.inscription_limiter"
        #[Autowire(service: 'limiter.inscription_limiter')] 
        RateLimiterFactory $inscriptionLimiter 
    ): Response {
        
        // --- 1. SÉCURITÉ : LIMITEUR DE DÉBIT (RATE LIMITER) ---
        // On identifie l'utilisateur par son adresse IP
        $limiter = $inscriptionLimiter->create($request->getClientIp());

        // On vérifie si l'utilisateur a encore le droit de tenter une inscription
        if (false === $limiter->consume(1)->isAccepted()) {
            $this->addFlash('danger', 'Trop de tentatives ! Votre accès est bloqué pendant 15 minutes.');
            return $this->redirectToRoute('app_home'); 
        }

        // --- 2. LOGIQUE D'INSCRIPTION ---
        $user = new Utilisateur();
        $user->setDateInscription(new \DateTime()); // Date auto

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

            // --- 3. CONNEXION AUTOMATIQUE (AUTO-LOGIN) ---
            // Une fois inscrit, il est direct connecté et envoyé vers l'étagère
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