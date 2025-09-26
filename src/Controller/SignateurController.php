<?php

namespace App\Controller;

use App\Entity\Signateur;
use App\Form\SignateurType;
use App\Repository\SignateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/signateur')]
final class SignateurController extends AbstractController
{
    #[Route(name: 'app_signateur_index', methods: ['GET', 'POST'])]
    public function index(SignateurRepository $signateurRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $signateur = new Signateur();
        $form = $this->createForm(SignateurType::class, $signateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($signateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_signateur_index', [], Response::HTTP_SEE_OTHER);
        }else if ($form->isSubmitted() ){
            
            return $this->render('signateur/index.html.twig', [
                'signateurs' => $signateurRepository->findAll(),
                'form' => $form->createView(),
                'openContactModal' => true,
                
            ]);
        }
        return $this->render('signateur/index.html.twig', [
            'signateurs' => $signateurRepository->findAll(),
            'form' => $form->createView(),
            'openContactModal' => false,
        ]);
        
    }

    #[Route('/new', name: 'app_signateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $signateur = new Signateur();
        $form = $this->createForm(SignateurType::class, $signateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($signateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_signateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('signateur/new.html.twig', [
            'signateur' => $signateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_signateur_show', methods: ['GET'])]
    public function show(Signateur $signateur): Response
    {
        return $this->render('signateur/show.html.twig', [
            'signateur' => $signateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_signateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Signateur $signateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SignateurType::class, $signateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_signateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('signateur/edit.html.twig', [
            'signateur' => $signateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_signateur_delete', methods: ['POST'])]
    public function delete(Request $request, Signateur $signateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$signateur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($signateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_signateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
