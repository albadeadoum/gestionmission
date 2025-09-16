<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Form\AgentType;
use App\Repository\AgentRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/agent')]
final class AgentController extends AbstractController
{
    #[Route(name: 'app_agent_index', methods: ['GET' , 'POST'])]
    public function index(Request $request, AgentRepository $agentRepository, EntityManagerInterface $entityManager, EvenementRepository $evenementRepository): Response
    {
        $agent = new Agent();
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('app_agent_index', [], Response::HTTP_SEE_OTHER);
        }else if ($form->isSubmitted() ){
            
            return $this->render('agent/index.html.twig', [
                'agents' => $agentRepository->findAll(),
                'form' => $form->createView(),
                'openContactModal' => true,
                'evenements' => $evenementRepository->findAll(),
                
            ]);
        }
        return $this->render('agent/index.html.twig', [
            'agents' => $agentRepository->findAll(),
            'form' => $form->createView(),
            'openContactModal' => false,
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_agent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $agent = new Agent();
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('app_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agent/new.html.twig', [
            'agent' => $agent,
            'form' => $form,
        ]);
    }

    #[Route('/search', name: 'agent_search', methods: ['GET'])]
public function search(Request $request, AgentRepository $agentRepository): JsonResponse
{
    $q = $request->query->get('q', '');
    $agents = $agentRepository->createQueryBuilder('a')
        ->where('a.nom LIKE :q OR a.prenom LIKE :q')
        ->setParameter('q', '%' . $q . '%')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult();

    $data = [];
    foreach ($agents as $agent) {
        $data[] = [
            'id' => $agent->getId(),
            'nom' => $agent->getNom(),
            'prenom' => $agent->getPrenom(),
            'service' => $agent->getService(),
        ];
    }
    return new JsonResponse($data);
}

    #[Route('/{id}', name: 'app_agent_show', methods: ['GET'])]
    public function show(Agent $agent): Response
    {
        return $this->render('agent/show.html.twig', [
            'agent' => $agent,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_agent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agent $agent,  EntityManagerInterface $entityManager): Response
    {
       // Vérifie que l'entité existe bien
       if (!$agent->getId()) {
        throw $this->createNotFoundException('Donnée non trouvée');
        }
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest() && $request->isMethod('GET')) {
            return new JsonResponse([
                'form' => $this->renderView('agent/_form.html.twig', [
                    'form' => $form->createView(),
                    'agent' => $agent,
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

    /*#[Route('/{id}/edit', name: 'app_agent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agent $agent, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_agent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agent/edit.html.twig', [
            'agent' => $agent,
            'form' => $form,
        ]);
    }#*/

    #[Route('/{id}', name: 'app_agent_delete', methods: ['POST'])]
    public function delete(Request $request, Agent $agent, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agent->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($agent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_agent_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
