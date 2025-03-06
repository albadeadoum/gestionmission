<?php

namespace App\Controller;

use App\Repository\CarburantRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MobileHomeController extends AbstractController
{
    #[Route('/mobile/home', name: 'app_mobile_home')]
    public function index(CarburantRepository $carburantRepository,UserRepository $userRepository,  Security $security): Response
    {
        // Récupérer l'utilisateur actuellement connecté
    //$user = $security->getUser();

    // Récupérer les carburants en relation avec l'utilisateur
    // $carburants = $user->getCarburant();

    // Récupérer les enregistrements de carburant liés à la mission actuelle
    $mission = $this->getUser()->getMission();
    $carburants = $carburantRepository->findByMission($mission);


    return $this->render('mobile_home/index.html.twig', [
            'controller_name' => 'MobileHomeController',
            'carburants' => $carburants,
            'users' => $userRepository->findAll(),
        ]);
    }
}
