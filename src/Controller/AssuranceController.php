<?php

namespace App\Controller;

use App\Entity\Assurance;
use App\Form\AssuranceType;
use App\Form\AssuranceTypeT;
use App\Repository\AssuranceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface as FormFormInterface;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/assurance')]
final class AssuranceController extends AbstractController
{
    #[Route('/', name: 'app_assurance_index', methods: ['GET', 'POST'])]
    public function index(Request $request, AssuranceRepository $assuranceRepository, EntityManagerInterface $entityManager): Response
    {
        $assurance = new Assurance();
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assurance);
            $entityManager->flush();
            return $this->redirectToRoute('app_assurance_index');
        }

        return $this->render('assurance/index.html.twig', [
            'assurances' => $assuranceRepository->findBy([], ['fin' => 'DESC']),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_assurance_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,LoggerInterface $logger): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(['success' => false, 'message' => 'Requête invalide'], Response::HTTP_BAD_REQUEST);
        }

        $assurance = new Assurance();
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($assurance);
            $entityManager->flush();
            return new JsonResponse(['success' => true]);
        }
        // Log des erreurs détaillées
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $logger->error('Validation Error: ' . $error->getMessage());
            $errors[] = $error->getMessage();
        }
        

        return new JsonResponse([
            'success' => false,
            'errors' => $errors,
        ]);
    }

    #[Route('/{id}', name: 'app_assurance_show', methods: ['GET'])]
    public function show(Assurance $assurance): Response
    {
        return $this->render('assurance/show.html.twig', [
            'carburant' => $assurance,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assurance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Assurance $assurance, EntityManagerInterface $entityManager): JsonResponse
    {

        // Vérifie que l'entité existe bien
        if (!$assurance->getId()) {
            throw $this->createNotFoundException('Assurance non trouvée');
        }
        $form = $this->createForm(AssuranceType::class, $assurance);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest() && $request->isMethod('GET')) {
            return new JsonResponse([
                'form' => $this->renderView('assurance/_form.html.twig', [
                    'form' => $form->createView(),
                    'assurance' => $assurance,
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

   

    #[Route('/{id}/delete', name: 'app_assurance_delete', methods: ['POST'])]
    public function delete(Request $request, Assurance $assurance, AssuranceRepository $assuranceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assurance->getId(), $request->request->get('_token'))) {
            $assuranceRepository->remove($assurance, true);
        }

        return $this->redirectToRoute('app_assurance_index', [], Response::HTTP_SEE_OTHER);
    }
}