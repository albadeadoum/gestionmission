<?php

namespace App\Controller;

use App\Entity\Carburant;
use App\Entity\Piece;
use App\Form\PieceType;
use App\Entity\Agent;
use App\Repository\CarburantRepository;
use App\Repository\EvenementRepository;
use App\Repository\PieceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForVehiculeController extends AbstractController
{
    #[Route('/for/vehicule/{id}', name: 'app_for_vehicule')]
    public function indexfor(PieceRepository $repository , int $id, EntityManagerInterface $entityManager): Response
    {
        $em = $entityManager;

        $piece = $repository->findBy(['Vehicule' => $id]);
        return $this->render('for/index.html.twig', [
            'pieces'=> $piece,
        ]);
    }
    #[Route('/for/vehicule/evenement/{id}', name: 'app_for_vehicule_evenement')]
    public function indexforvehicule(EvenementRepository $evenement , int $id, EntityManagerInterface $entityManager): Response
    {
        $evenements = $evenement->findBy(['Vehicule' => $id]);
        return $this->render('for/vehicule.html.twig', [
            'evenements'=> $evenements,
        ]);
    }
    #[Route('/for/chauffeur/evenement/{id}', name: 'app_for_chauffeur_evenement')]
    public function indexforchauffeur(EvenementRepository $evenement , int $id, EntityManagerInterface $entityManager): Response
    {
        $evenements = $evenement->findBy(['Chauffeur' => $id]);
        return $this->render('for/chauffeur.html.twig', [
            'evenements'=> $evenements,
        ]);
    }
    #[Route('/for/carburant/evenement/{id}', name: 'app_for_carburant_evenement')]
    public function indexforCarburant(CarburantRepository $carburants , int $id, ): Response
    {
        $carburant = $carburants->findBy(['mission' => $id]);
        return $this->render('for/carburant.html.twig', [
            'carburants'=> $carburant,
        ]);
    }
    #[Route('/for/mission/evement/{id}', name: 'app_for_mission')]
    public function indexformission(PieceRepository $repository , int $id, EntityManagerInterface $entityManager): Response
    {
        $em = $entityManager;

        $piece = $repository->findBy(['event' => $id]);
        return $this->render('for/piece.html.twig', [
            'pieces'=> $piece,
        ]);
    }
    #[Route('/for/agent/evenement/{id}', name: 'app_for_agent_evenement')]
    public function indexforagent(EvenementRepository $evenement , int $id, EntityManagerInterface $entityManager): Response
    {
        $evenements = $evenement->findBy(['agents' => $id]);
        return $this->render('for/agent.html.twig', [
            'evenements'=> $evenements,
        ]);
    }
    /*#[Route('/for/vehicule', name: 'app_for_vehicule')]
    public function index(): Response
    {
        return $this->render('for_vehicule/index.html.twig', [
            'controller_name' => 'ForVehiculeController',
        ]);
    }*/
}
