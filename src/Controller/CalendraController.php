<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CalendraController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/calendra', name: 'app_calendra')]
    public function index(EvenementRepository $event): Response
    {

        
        $evenement = $event -> findAll();

        $rdvs = [];

        foreach( $evenement as $event){
            $rdvs [] = [
                'id' => $event->getId(),
                'start' => $event->getDebut()->format('Y-m-d H:i:s'),
                'end' => $event->getFin()->format('Y-m-d H:i:s'),
                'title' => $event->getVehicule(),
                'Vehicule' => $event->getVehicule(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackgroundColor(),
                'borderColor' => $event->getBorderColor(),
                'textColor' => $event->getTextColor()
            ];
        }
        
        $data = json_encode($rdvs);
        return $this->render('calendra/index.html.twig', compact('data'));
    }
}
