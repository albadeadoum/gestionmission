<?php

namespace App\Controller;

use App\Entity\Bailleur;
use App\Form\BailleurType;
use App\Repository\BailleurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/bailleur')]
final class BailleurController extends AbstractController
{
    #[Route(name: 'app_bailleur_index', methods: ['GET' , 'POST'])]
    public function index(Request $request, BailleurRepository $bailleurRepository , EntityManagerInterface $entityManager): Response
    {
        $bailleur = new Bailleur();
        $form = $this->createForm(BailleurType::class, $bailleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bailleur);
            $entityManager->flush();

            return $this->redirectToRoute('app_bailleur_index', [], Response::HTTP_SEE_OTHER);
        }else if ($form->isSubmitted() ){
            
            return $this->render('bailleur/index.html.twig', [
                'bailleurs' => $bailleurRepository->findAll(),
                'form' => $form->createView(),
                'openContactModal' => true,
                
            ]);
        }
        return $this->render('bailleur/index.html.twig', [
            'bailleurs' => $bailleurRepository->findAll(),
            'form' => $form->createView(),
            'openContactModal' => false,
        ]);
    }

    #[Route('/new', name: 'app_bailleur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bailleur = new Bailleur();
        $form = $this->createForm(BailleurType::class, $bailleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bailleur);
            $entityManager->flush();

            return $this->redirectToRoute('app_bailleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bailleur/new.html.twig', [
            'bailleur' => $bailleur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bailleur_show', methods: ['GET'])]
    public function show(Bailleur $bailleur): Response
    {
        return $this->render('bailleur/show.html.twig', [
            'bailleur' => $bailleur,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_bailleur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bailleur $bailleur,  EntityManagerInterface $entityManager): Response
    {
       // Vérifie que l'entité existe bien
       if (!$bailleur->getId()) {
        throw $this->createNotFoundException('Donnée non trouvée');
        }
        $form = $this->createForm(BailleurType::class, $bailleur);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest() && $request->isMethod('GET')) {
            return new JsonResponse([
                'form' => $this->renderView('bailleur/_form.html.twig', [
                    'form' => $form->createView(),
                    'bailleur' => $bailleur,
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


    #[Route('/{id}', name: 'app_bailleur_delete', methods: ['POST'])]
    public function delete(Request $request, Bailleur $bailleur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bailleur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bailleur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bailleur_index', [], Response::HTTP_SEE_OTHER);
    }
}
