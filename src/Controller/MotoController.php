<?php

namespace App\Controller;

use App\Entity\Moto;
use App\Form\MotoType;
use App\Repository\MotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[IsGranted('ROLE_USER')]
#[Route('/moto')]
final class MotoController extends AbstractController{
    #[Route(name: 'app_moto_index', methods: ['GET', 'POST'])]
    public function index(Request $request, MotoRepository $motoRepository): Response
    {
        $moto = new moto();
        $form = $this->createForm(MotoType::class, $moto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $motoRepository->save($moto, true);

            return $this->redirectToRoute('app_moto_index', [], Response::HTTP_SEE_OTHER);
        }else if ($form->isSubmitted() ){
            
            return $this->render('moto/index.html.twig', [
                'motos' => $motoRepository->findAll(),
                'form' => $form->createView(),
                'openContactModal' => true,
                
            ]);
        }
        return $this->render('moto/index.html.twig', [
            'motos' => $motoRepository->findAll(),
            'form' => $form->createView(),
            'openContactModal' => false,
        ]);
    }

    #[Route('/new', name: 'app_moto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $moto = new Moto();
        $form = $this->createForm(MotoType::class, $moto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($moto);
            $entityManager->flush();

            return $this->redirectToRoute('app_moto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('moto/new.html.twig', [
            'moto' => $moto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_moto_show', methods: ['GET'])]
    public function show(Moto $moto): Response
    {
        return $this->render('moto/show.html.twig', [
            'moto' => $moto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_moto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Moto $moto, EntityManagerInterface $entityManager): Response
    {
        
        // Vérifie que l'entité existe bien
        if (!$moto->getId()) {
            throw $this->createNotFoundException(' non trouvée');
        }

        $form = $this->createForm(MotoType::class, $moto);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest() && $request->isMethod('GET')) {
            return new JsonResponse([
                'form' => $this->renderView('moto/_form.html.twig', [
                    'form' => $form->createView(),
                    'moto' => $moto,
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
    
   
    #[Route('/{id}', name: 'app_moto_delete', methods: ['POST'])]
    public function delete(Request $request, Moto $moto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moto->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($moto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_moto_index', [], Response::HTTP_SEE_OTHER);
    }
}
