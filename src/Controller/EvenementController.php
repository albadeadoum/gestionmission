<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Form\EveneType;
use App\Form\EvenementTypeReserver;
use App\Form\rapportevenementType;
use App\Repository\EvenementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\AgentRepository;
use DateTime;
use App\Entity\Agent; 

use Doctrine\ORM\EntityManagerInterface;

#[IsGranted('ROLE_USER')]
#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index', methods: ['GET', 'POST'])]
    public function index(Request $request, EvenementRepository $evenementRepository, SessionInterface $session): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementTypeReserver::class, $evenement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Convertir les dates au format DateTime avant de vérifier leur disponibilité
            $debut = $evenement->getDebut();
            $fin = $evenement->getFin();
    
            $vehicule = $evenement->getVehicule();
            $chauffeur = $evenement->getChauffeur();
    
            if (!$evenementRepository->isVehiculeAvailable($vehicule, $debut, $fin) || !$evenementRepository->isChauffeurAvailable($chauffeur, $debut, $fin)) {
                // Ajouter un flash message d'erreur
                $session->getFlashBag()->add('error', 'Le véhicule ou le chauffeur n\'est pas disponible aux dates sélectionnées.');
    
                // Rediriger l'utilisateur vers la page précédente (dans ce cas, le formulaire de création d'événement)
                return $this->render('evenement/index.html.twig', [
                    'evenements' => $evenementRepository->findAll(),
                    'evenement' => $evenement,
                    'form' => $form->createView(),
                    'openContactModal' => true, // Ouvrir le modal pour afficher l'erreur
                ]);
            } else {
                // Le véhicule et le chauffeur sont disponibles, enregistrez l'événement
                $evenementRepository->save($evenement, true);
    
                // Ajouter un flash message de succès
                $session->getFlashBag()->add('success', 'La Mission a été créé avec succès.');
    
                // Rediriger l'utilisateur vers une autre page, par exemple, la liste des événements
                return $this->redirectToRoute('app_evenement_index');
            }
        }
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
            'evenement' => $evenement,
            'form' => $form->createView(),
            'openContactModal' => false,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EvenementRepository $evenementRepository, SessionInterface $session): Response
    {$evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Convertir les dates au format DateTime avant de vérifier leur disponibilité
            $debut = $evenement->getDebut();
            $fin = $evenement->getFin();
    
            $vehicule = $evenement->getVehicule();
            $chauffeur = $evenement->getChauffeur();
    
            if (!$evenementRepository->isVehiculeAvailable($vehicule, $debut, $fin) || !$evenementRepository->isChauffeurAvailable($chauffeur, $debut, $fin)) {
                // Ajouter un flash message d'erreur
                $session->getFlashBag()->add('error', 'Le véhicule ou le chauffeur n\'est pas disponible aux dates sélectionnées.');
    
                // Rediriger l'utilisateur vers la page précédente (dans ce cas, le formulaire de création d'événement)
                return $this->redirectToRoute('app_evenement_new');
            } else {
                // Le véhicule et le chauffeur sont disponibles, enregistrez l'événement
                $evenementRepository->save($evenement, true);
    
                // Ajouter un flash message de succès
                $session->getFlashBag()->add('success', 'La Mission a été créé avec succès.');
    
                // Rediriger l'utilisateur vers une autre page, par exemple, la liste des événements
                return $this->redirectToRoute('app_evenement_index');
            }
        }
    
        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new/reserver', name: 'app_evenement_new_reserver', methods: ['GET', 'POST'])]
    public function newr(Request $request, EvenementRepository $evenementRepository, SessionInterface $session): Response
    {$evenement = new Evenement();
        $form = $this->createForm(EvenementTypeReserver::class, $evenement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Convertir les dates au format DateTime avant de vérifier leur disponibilité
            $debut = $evenement->getDebut();
            $fin = $evenement->getFin();
    
            $vehicule = $evenement->getVehicule();
            $chauffeur = $evenement->getChauffeur();
    
            if (!$evenementRepository->isVehiculeAvailable($vehicule, $debut, $fin) || !$evenementRepository->isChauffeurAvailable($chauffeur, $debut, $fin)) {
                // Ajouter un flash message d'erreur
                $session->getFlashBag()->add('error', 'Le véhicule ou le chauffeur n\'est pas disponible aux dates sélectionnées.');
    
                // Rediriger l'utilisateur vers la page précédente (dans ce cas, le formulaire de création d'événement)
                return $this->redirectToRoute('app_evenement_new');
            } else {
                // Le véhicule et le chauffeur sont disponibles, enregistrez l'événement
                $evenementRepository->save($evenement, true);
    
                // Ajouter un flash message de succès
                $session->getFlashBag()->add('success', 'La Mission a été créé avec succès.');
    
                // Rediriger l'utilisateur vers une autre page, par exemple, la liste des événements
                return $this->redirectToRoute('app_evenement_index');
            }
        }
    
        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        $form = $this->createForm(EveneType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->save($evenement, true);

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $evenementRepository->remove($evenement, true);
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/add-agent', name: 'evenement_add_agent', methods: ['POST'])]
    public function addAgent(
        Request $request,
        Evenement $evenement,
        AgentRepository $agentRepository,
        EntityManagerInterface $em,
        EvenementRepository $evenementRepository
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $agentId = $data['agentId'] ?? null;

        if (!$agentId) {
            return new JsonResponse(['success' => false, 'message' => 'Aucun agent fourni'], 400);
        }

        $agent = $agentRepository->find($agentId);
        if (!$agent) {
            return new JsonResponse(['success' => false, 'message' => 'Agent introuvable'], 404);
        }

        // Vérifie si l'agent est déjà associé
        if ($evenement->getAgents()->contains($agent)) {
            return new JsonResponse(['success' => false, 'message' => 'Cet agent est déjà ajouté à la mission.']);
        }

        // Vérification disponibilité agent
        $debut = $evenement->getDebut();
        $fin   = $evenement->getFin();

        // On récupère toutes les missions où cet agent est déjà affecté
        $missionsEnCours = $evenementRepository->createQueryBuilder('e')
            ->join('e.agents', 'a')
            ->where('a.id = :agentId')
            ->andWhere('(:debut BETWEEN e.debut AND e.fin) OR (:fin BETWEEN e.debut AND e.fin) OR (e.debut <= :debut AND e.fin >= :fin)')
            ->setParameter('agentId', $agent->getId())
            ->setParameter('debut', $debut)
            ->setParameter('fin', $fin)
            ->getQuery()
            ->getResult();

        if (count($missionsEnCours) > 0) {
            return new JsonResponse(['success' => false, 'message' => 'Cet agent a déjà une mission en cours pendant cette période.']);
        }

        $evenement->addAgent($agent);
        $em->flush();

        return new JsonResponse(['success' => true]);
        }
        #[Route('/{evenement}/remove-agent/{agent}', name: 'evenement_remove_agent', methods: ['POST'])]
        public function removeAgent(
            Evenement $evenement,
            Agent $agent,
            EntityManagerInterface $em
        ): JsonResponse {
            if ($evenement->getAgents()->contains($agent)) {
                $evenement->removeAgent($agent);
                $em->flush();
                return new JsonResponse(['success' => true]);
            }
            return new JsonResponse(['success' => false, 'message' => 'Cet agent n\'est pas associé à la mission.']);
        }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/rapport/{id}/edit', name: 'app_event_rapport_edit', methods: ['GET', 'POST'])]
    public function editrapport(Request $request, Evenement $evenement, EvenementRepository $evenementRepository, EntityManagerInterface $entityManager): Response
    {
        // Vérifie que l'entité existe bien
        if (!$evenement->getId()) {
            throw $this->createNotFoundException(' non trouvée');
        }

        $form = $this->createForm(rapportevenementType::class, $evenement);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest() && $request->isMethod('GET')) {
            return new JsonResponse([
                'form' => $this->renderView('evenement/_formrapport.html.twig', [
                    'form' => $form->createView(),
                    'evenement' => $evenement,
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

    
}
