<?php

namespace App\Controller;

use App\Entity\Carburant;
use App\Entity\Evenement;
use App\Entity\User;
use App\Form\CarburantType;
use App\Form\CarburantTypeMobile;
use App\Repository\CarburantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/carburant')]
class CarburantController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_carburant_index', methods: ['GET'])]
    public function index(Request $request, CarburantRepository $carburantRepository): Response
    {
        $missionId = $request->query->get('mission');
        if ($missionId) {
            $mission = $this->entityManager->getRepository(Evenement::class)->find($missionId);
            $carburants = $mission->getCarburants();
        } else {
            $carburants = $carburantRepository->findAll();
        }
    
        $missions = $this->entityManager->getRepository(Evenement::class)->findAll();
    
        return $this->render('carburant/index.html.twig', [
            'carburants' => $carburants,
            'missions' => $missions,
        ]);
       /* return $this->render('carburant/index.html.twig', [
            'carburants' => $carburantRepository->findAll(),
        ]);*/
    }

    #[Route('/new', name: 'app_carburant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarburantRepository $carburantRepository, SessionInterface $session,User $user, int $id, EntityManagerInterface $entityManager): Response
    {
        $carburant = new Carburant();
        $form = $this->createForm(CarburantType::class, $carburant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /*// Vérifier si les valeurs de longitude et latitude sont null
            if ($carburant->getLongitude() === null || $carburant->getLatitude() === null) {
                // Ajouter un message flash d'erreur ou d'avertissement
                $session->getFlashBag()->add('warning', 'Veuillez spécifier les coordonnées (latitude et longitude)');
    
                // Rediriger l'utilisateur vers la page du formulaire avec le message flash
                return $this->redirectToRoute('app_carburant_new');
            }*/
    
            // Les valeurs de longitude et latitude sont définies, on peut enregistrer l'entité
            $carburantRepository->save($carburant, true);
    
            // Ajouter un message flash de succès
            $session->getFlashBag()->add('success', 'Le carburant a été enregistré avec succès.');
    
            return $this->redirectToRoute('app_carburant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carburant/new.html.twig', [
            'carburant' => $carburant,
            'form' => $form,
        ]);
    }

    #[Route('/new_mobile/{id}', name: 'app_carburant_mobile_new', methods: ['GET', 'POST'])]
    public function new_mobile(Request $request, CarburantRepository $carburantRepository, SessionInterface $session, Evenement $evenement, int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'événement (Evenement) à partir de l'identifiant
    $evenement = $entityManager->getRepository(Evenement::class)->find($id);

    $carburant = new Carburant();
    $carburant->setMission($evenement);
    $form = $this->createForm(CarburantTypeMobile::class, $carburant);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Vérifier si les valeurs de longitude et latitude sont null
       /* if ($carburant->getLongitude() === null || $carburant->getLatitude() === null) {
            // Ajouter un message flash d'erreur ou d'avertissement
            $session->getFlashBag()->add('warning', 'Veuillez spécifier les coordonnées (latitude et longitude)');

            // Rediriger l'utilisateur vers la page du formulaire avec le message flash
            return $this->redirectToRoute('app_carburant_mobile_new', ['id' => $evenement->getId()], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_carburant_mobile_new', ['id' => $evenement->getId()]);
        }*/

        // Les valeurs de longitude et latitude sont définies, on peut enregistrer l'entité
        $carburantRepository->save($carburant, true);


        // Ajouter un message flash de succès
        $session->getFlashBag()->add('success', 'Le carburant a été enregistré avec succès.');

        return $this->redirectToRoute('app_mobile_home', ['id' => $evenement->getId()], Response::HTTP_SEE_OTHER);
    }

        return $this->renderForm('carburant/new_mobile.html.twig', [
            'carburant' => $carburant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carburant_show', methods: ['GET'])]
    public function show(Carburant $carburant): Response
    {
        return $this->render('carburant/show.html.twig', [
            'carburant' => $carburant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_carburant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carburant $carburant, CarburantRepository $carburantRepository): Response
    {
        $form = $this->createForm(CarburantType::class, $carburant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carburantRepository->save($carburant, true);

            return $this->redirectToRoute('app_carburant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carburant/edit.html.twig', [
            'carburant' => $carburant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carburant_delete', methods: ['POST'])]
    public function delete(Request $request, Carburant $carburant, CarburantRepository $carburantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carburant->getId(), $request->request->get('_token'))) {
            $carburantRepository->remove($carburant, true);
        }

        return $this->redirectToRoute('app_carburant_index', [], Response::HTTP_SEE_OTHER);
    }
}
