<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Form\AssuranceType;
use App\Form\PieceType;
use App\Repository\PieceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
#[Route('/piece')]
class PieceController extends AbstractController
{
    #[Route('/', name: 'app_piece_index', methods: ['GET', 'POST'])]
    public function index(Request $request, PieceRepository $pieceRepository, EntityManagerInterface $entityManager): Response
    {
        $piece = new Piece();
        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($piece);
            $entityManager->flush();
            return $this->redirectToRoute('app_piece_index');
        }
        return $this->render('piece/index.html.twig', [
            'pieces' => $pieceRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_piece_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PieceRepository $pieceRepository): Response
    {
        $piece = new Piece();
        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pieceRepository->save($piece, true);
            if ($request->isXmlHttpRequest()) {
        return $this->json(['success' => true]);
    }

            return $this->redirectToRoute('app_piece_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('piece/new.html.twig', [
            'piece' => $piece,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_piece_show', methods: ['GET'])]
    public function show(Piece $piece): Response
    {
        return $this->render('piece/show.html.twig', [
            'piece' => $piece,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_piece_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Piece $piece,  EntityManagerInterface $entityManager): Response
    {
       // Vérifie que l'entité existe bien
       if (!$piece->getId()) {
        throw $this->createNotFoundException('Donnée non trouvée');
        }
        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest() && $request->isMethod('GET')) {
            return new JsonResponse([
                'form' => $this->renderView('piece/_form.html.twig', [
                    'form' => $form->createView(),
                    'piece' => $piece,
                ])
            ]);
        }

        if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                // Pas besoin de persist() pour une entité déjà gérée par Doctrine
                $entityManager->flush();

                return new JsonResponse(['success' => true]);
            }

            // Récupérer les erreurs du formulaire
            $errors = [];
            foreach ($form->getErrors(true, false) as $error) {
                $errors[] = $error->getMessage();
            }

            return new JsonResponse([
                'success' => false,
                'errors' => $errors,
            ]);
        }

        return new JsonResponse([
            'success' => false,
            'message' => 'Requête invalide'
        ], Response::HTTP_BAD_REQUEST);
    }

    /*#[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_piece_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Piece $piece, PieceRepository $pieceRepository): Response
    {
        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pieceRepository->save($piece, true);

            // Si la requête est AJAX, renvoyer une réponse JSON
            if ($request->isXmlHttpRequest()) {
                return $this->json(['success' => true]);
            }

            // Si ce n'est pas une requête AJAX, effectuer la redirection classique
            return $this->redirectToRoute('app_piece_index', [], Response::HTTP_SEE_OTHER);
        }

        // Si la requête n'est pas une soumission AJAX, on affiche le formulaire normalement
        return $this->renderForm('piece/edit.html.twig', [
            'piece' => $piece,
            'form' => $form,
        ]);
    }*/

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_piece_delete', methods: ['POST'])]
    public function delete(Request $request, Piece $piece, PieceRepository $pieceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$piece->getId(), $request->request->get('_token'))) {
            $pieceRepository->remove($piece, true);
        }

        return $this->redirectToRoute('app_piece_index', [], Response::HTTP_SEE_OTHER);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/piece.for/{id}', name: 'app_piece_for')]
    public function indexfor(PieceRepository $repository , int $id, EntityManagerInterface $entityManager): Response
    {
        $em = $entityManager;

        $piece = $repository->findBy(['Vehicule' => $id]);
        return $this->render('piece/index.html.twig', [
            'pieces'=> $piece,
        ]);
    }
}
