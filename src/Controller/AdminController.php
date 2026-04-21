<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Repository\JeuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_dashboard')]
    public function index(UtilisateurRepository $userRepo, JeuRepository $jeuRepo): Response
    {
        // 1. On récupère les compteurs pour les stats
        $totalUsers = $userRepo->count([]);
        $totalGames = $jeuRepo->count([]);

        // 2. 🚀 ON RÉCUPÈRE LES DONNÉES POUR LES TABLEAUX ET LES MODALES
        // On récupère tous les utilisateurs (triés par date d'inscription la plus récente)
        $users = $userRepo->findBy([], ['date_inscription' => 'DESC']);
        
        // On récupère tous les jeux du catalogue
        $jeux = $jeuRepo->findAll();

        // 3. On envoie TOUT à la vue
        return $this->render('admin/index.html.twig', [
            'totalUsers' => $totalUsers,
            'totalGames' => $totalGames,
            'users'      => $users, // 👈 C'est cette variable qui manquait !
            'jeux'       => $jeux,  // 👈 On en profite pour envoyer les jeux aussi
        ]);
    }
}