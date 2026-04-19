<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Repository\JeuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_dashboard')]
    public function index(UtilisateurRepository $userRepo, JeuRepository $jeuRepo): Response
    {
        // On récupère le nombre total d'utilisateurs inscrits en BDD
        $totalUsers = $userRepo->count([]);
        $totalGames = $jeuRepo->count([]);
        
        return $this->render('admin/index.html.twig', [
            'totalUsers' => $totalUsers,
            'totalGames' => $totalGames,
        ]);
    }
}