<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/wishes')]
final class WishController extends AbstractController
{
    #[Route('/', name: 'wish_home')]
    public function list(): Response
    {
        return $this->render('wish/list.html.twig', []);
    }
    #[Route('/{id}', name: 'wish_detail')]
    public function detail(int $id): Response
    {
        return $this->render('wish/detail.html.twig', []);
    }
}