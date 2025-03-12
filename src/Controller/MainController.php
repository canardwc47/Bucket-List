<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'main_home')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', []);
    }
    #[Route('/about', name: 'main_about', methods: ['GET'])]
    public function about(): Response
    {
        return $this->render('main/aboutUs.html.twig', []);
    }
}
