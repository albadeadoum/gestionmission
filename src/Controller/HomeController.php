<?php

namespace App\Controller;

use App\Repository\AssuranceRepository;
use App\Repository\ChauffeurRepository;
use App\Repository\EvenementRepository;
use App\Repository\MotoRepository;
use App\Repository\PieceRepository;
use App\Repository\VehiculeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index( EvenementRepository $event, VehiculeRepository $vehiculeRepository,
     EvenementRepository $evenementRepository, ChauffeurRepository $chauffeurRepository, MotoRepository $motoRepository, 
     AssuranceRepository $assuranceRepository, PieceRepository $pieceRepository,): Response
    {
        $evenement = $event -> findAll();
        $v = 1;

        $rdvs = [];

        foreach( $evenement as $event){
            $rdvs [] = [
                'id' => $event->getId(),
                'start' => $event->getDebut()->format('Y-m-d'),
                'end' => $event->getFin()->format('Y-m-d'),
                 $veh = $event->getVehicule(),
                 $chauf = $event->getChauffeur(),
                 $titre = $event->getTitre(),
                'title' => $titre .' - ' .$veh.' - '.  $chauf,
                'Vehicule' => $event->getVehicule(),
                'Chauffeur' => $event->getChauffeur(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor()
            ];
        }
        $data = json_encode($rdvs);
        return $this->render('home/index.html.twig',   [
            'controller_name' => 'HomeController',
            'data' => $data,
            'vehicules' => $vehiculeRepository->findAll(),
            'evenements' => $evenementRepository->findAll(),
            'chauffeurs' => $chauffeurRepository->findAll(),
            'motos' => $motoRepository->findAll(),
            'assurances' => $assuranceRepository->findBy([], ['fin' => 'DESC']),
            'pieces' => $pieceRepository->findAll(),
        ] );
        
    }
}
