<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category/add{wishId}', name: 'add_category')]
    public function add(Request                $request,
                        EntityManagerInterface $entityManager,
                        WishRepository         $wishRepository,
                        int                    $wishId = null
    ): Response
    {
        $category = new Category();
        if($wishId){
            $wish = $wishRepository->find($wishId);
            $category->setWish($wish);
            $category->setName($wish->getTitle());
        }
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
