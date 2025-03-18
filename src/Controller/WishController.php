<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/wishes', name: 'wishes_')]
final class WishController extends AbstractController
{
    #[Route('/', name: 'wish_home', methods: ['GET'])]
    public function list(WishRepository $wishRepository): Response
    {
        //Rcupere les wish publiés, du plus récent au plus ancien
        $wishes = $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'DESC']);
        return $this->render('wish/list.html.twig', ['wishes' => $wishes]);
    }

    #[Route('/{id}', name: 'wish_detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function wish_detail(Wish $wish, WishRepository $wishRepository): Response
    {
        return $this->render('wish/detail.html.twig', ['wish' => $wish]);
    }

    #[Route('/ajouter', name: 'wish_add', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);
        //traiter le formulaire
        $wishForm->handleRequest($request);
        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $em->persist($wish);
            $em->flush();
            $this->addFlash('sucess', 'Le souhait a bien ete ajouté');
            return $this->redirectToRoute('wishes_wish_home', ['id' => $wish->getId()]);
        }
        return $this->render('wish/creer.html.twig', ['wishForm' => $wishForm]);
    }

    #[Route('/{id}/modifier', name: 'wish_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(
        Wish                   $wish,
        Request                $request,
        EntityManagerInterface $entityManager
    ): Response {
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);
        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            $wish->setDateUpdated(new \DateTimeImmutable());
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success', 'Le souhait a bien été modifié');
            return $this->redirectToRoute('wishes_wish_detail', ['id' => $wish->getId()]);
        }

        return $this->render('wish/edit.html.twig', [
            'wishForm' => $wishForm->createView() // Il faut appeler createView() pour passer le formulaire à Twig
        ]);
    }

    #[Route('/{id}/supprimer', name: 'wish_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(int $id, EntityManagerInterface $entityManager, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);

        if (!$wish) {
            throw $this->createNotFoundException("Le souhait avec l'ID $id n'existe pas.");
        }

        $entityManager->remove($wish);
        $entityManager->flush();

        $this->addFlash('success', 'Le souhait a été supprimé avec succès.');

        return $this->redirectToRoute('wishes_wish_home');
    }


}