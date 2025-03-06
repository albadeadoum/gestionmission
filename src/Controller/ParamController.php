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

class ParamController extends AbstractController
{
   
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_kilometre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Kilometre $kilometre, KilometreRepository $kilometreRepository): Response
    {
        $form = $this->createForm(KilometreType::class, $kilometre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $kilometreRepository->save($kilometre, true);

            return $this->redirectToRoute('app_kilometre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('param/index.html.twig', [
            'kilometre' => $kilometre,
            'form' => $form,
        ]);
    }
    /*#[Route('/param', name: 'app_param')]
    public function index(): Response
    {
        return $this->render('param/index.html.twig', [
            'controller_name' => 'ParamController',
        ]);
    }*/
}
