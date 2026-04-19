<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EtagereController extends AbstractController
{
    #[Route('/mon-etagere', name: 'app_etagere')]
    public function index(): Response
    {
        return $this->render('etagere/index.html.twig', [
            'controller_name' => 'EtagereController',
        ]);
    }
}
