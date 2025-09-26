<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Form\VehiType;
use App\Repository\EvenementRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
#[Route('/vehicule')]
class VehiculeController extends AbstractController
{
    #[Route( name: 'app_vehicule_index', methods: ['GET', 'POST'])]
    public function index(Request $request, VehiculeRepository $vehiculeRepository, EvenementRepository $evenementRepository): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $vehiculeRepository->save($vehicule, true);

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }else if ($form->isSubmitted() ){
            
            return $this->render('vehicule/index.html.twig', [
                'form' => $form->createView(),
                'vehicules' => $vehiculeRepository->findAll(),
                'evenements' => $evenementRepository->findAll(),
                'openContactModal' => true,
                
            ]);
        }
        return $this->render('vehicule/index.html.twig', [
            
            'vehicules' => $vehiculeRepository->findAll(),
            'evenements' => $evenementRepository->findAll(),
            'form' => $form->createView(),
            'openContactModal' => false,
            
        ]);
    }


    


    #[Route('/new', name: 'app_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehiculeRepository->save($vehicule, true);

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicule_show', methods: ['GET'])]
    public function show(Vehicule $vehicule, Request $request,): Response
    {
        if ($request->isXmlHttpRequest() && $request->isMethod('GET')) {
            return new JsonResponse([
                'vehicule' => $this->renderView('vehicule/show.html.twig', [
                    'vehicule' => $vehicule,
                ])
            ]);
        }
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

   


    #[Route('/{id}/edit', name: 'app_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicule $vehicule, VehiculeRepository $vehiculeRepository, EntityManagerInterface $entityManager): Response
    {
        // Vérifie que l'entité existe bien
        if (!$vehicule->getId()) {
            throw $this->createNotFoundException(' non trouvée');
        }

        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest() && $request->isMethod('GET')) {
            return new JsonResponse([
                'form' => $this->renderView('vehicule/_form.html.twig', [
                    'form' => $form->createView(),
                    'vehicule' => $vehicule,
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

    

    #[Route('/{id}', name: 'app_vehicule_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicule $vehicule, VehiculeRepository $vehiculeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getId(), $request->request->get('_token'))) {
            $vehiculeRepository->remove($vehicule, true);
        }

        return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }

    
   
}
