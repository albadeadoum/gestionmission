<?php

namespace App\Controller;

use App\Entity\Kilometre;
use App\Form\KilometreType;
use App\Repository\KilometreRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[IsGranted('ROLE_ADMIN')]
#[Route('/kilometre')]
class KilometreController extends AbstractController
{
    #[Route('/', name: 'app_kilometre_index', methods: ['GET'])]
    public function index(KilometreRepository $kilometreRepository): Response
    {
        return $this->render('kilometre/index.html.twig', [
            'kilometres' => $kilometreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_kilometre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, KilometreRepository $kilometreRepository): Response
    {
        $kilometre = new Kilometre();
        $form = $this->createForm(KilometreType::class, $kilometre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $kilometreRepository->save($kilometre, true);

            return $this->redirectToRoute('app_kilometre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kilometre/new.html.twig', [
            'kilometre' => $kilometre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_kilometre_show', methods: ['GET'])]
    public function show(Kilometre $kilometre): Response
    {
        return $this->render('kilometre/show.html.twig', [
            'kilometre' => $kilometre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_kilometre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Kilometre $kilometre, KilometreRepository $kilometreRepository): Response
    {
        $form = $this->createForm(KilometreType::class, $kilometre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $kilometreRepository->save($kilometre, true);

            return $this->redirectToRoute('app_kilometre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kilometre/edit.html.twig', [
            'kilometre' => $kilometre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_kilometre_delete', methods: ['POST'])]
    public function delete(Request $request, Kilometre $kilometre, KilometreRepository $kilometreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$kilometre->getId(), $request->request->get('_token'))) {
            $kilometreRepository->remove($kilometre, true);
        }

        return $this->redirectToRoute('app_kilometre_index', [], Response::HTTP_SEE_OTHER);
    }
}
