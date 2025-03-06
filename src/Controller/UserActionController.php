<?php

namespace App\Controller;

use App\Entity\UserAction;
use App\Form\UserActionType;
use App\Repository\UserActionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/action')]
class UserActionController extends AbstractController
{
    #[Route('/', name: 'app_user_action_index', methods: ['GET'])]
    public function index(UserActionRepository $userActionRepository): Response
    {
        return $this->render('user_action/index.html.twig', [
            'user_actions' => $userActionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_action_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserActionRepository $userActionRepository): Response
    {
        $userAction = new UserAction();
        $form = $this->createForm(UserActionType::class, $userAction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userActionRepository->save($userAction, true);

            return $this->redirectToRoute('app_user_action_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_action/new.html.twig', [
            'user_action' => $userAction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_action_show', methods: ['GET'])]
    public function show(UserAction $userAction): Response
    {
        return $this->render('user_action/show.html.twig', [
            'user_action' => $userAction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_action_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserAction $userAction, UserActionRepository $userActionRepository): Response
    {
        $form = $this->createForm(UserActionType::class, $userAction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userActionRepository->save($userAction, true);

            return $this->redirectToRoute('app_user_action_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_action/edit.html.twig', [
            'user_action' => $userAction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_action_delete', methods: ['POST'])]
    public function delete(Request $request, UserAction $userAction, UserActionRepository $userActionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userAction->getId(), $request->request->get('_token'))) {
            $userActionRepository->remove($userAction, true);
        }

        return $this->redirectToRoute('app_user_action_index', [], Response::HTTP_SEE_OTHER);
    }
}
