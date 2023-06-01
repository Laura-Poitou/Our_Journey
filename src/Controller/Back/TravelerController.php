<?php

namespace App\Controller\Back;

use App\Entity\Traveler;
use App\Form\Back\CompleteTravelerType;
use App\Repository\TravelerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/traveler')]
class TravelerController extends AbstractController
{
    #[Route('/', name: 'app_back_traveler_index', methods: ['GET'])]
    public function index(TravelerRepository $travelerRepository): Response
    {
        return $this->render('back/traveler/index.html.twig', [
            'travelers' => $travelerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_traveler_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TravelerRepository $travelerRepository): Response
    {
        $traveler = new Traveler();
        $form = $this->createForm(CompleteTravelerType::class, $traveler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travelerRepository->save($traveler, true);

            return $this->redirectToRoute('app_back_traveler_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/traveler/new.html.twig', [
            'traveler' => $traveler,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_traveler_show', methods: ['GET'])]
    public function show(Traveler $traveler): Response
    {
        return $this->render('back/traveler/show.html.twig', [
            'traveler' => $traveler,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_traveler_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Traveler $traveler, TravelerRepository $travelerRepository): Response
    {
        $form = $this->createForm(CompleteTravelerType::class, $traveler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travelerRepository->save($traveler, true);

            return $this->redirectToRoute('app_back_traveler_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/traveler/edit.html.twig', [
            'traveler' => $traveler,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_traveler_delete', methods: ['POST'])]
    public function delete(Request $request, Traveler $traveler, TravelerRepository $travelerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$traveler->getId(), $request->request->get('_token'))) {
            $travelerRepository->remove($traveler, true);
        }

        return $this->redirectToRoute('app_back_traveler_index', [], Response::HTTP_SEE_OTHER);
    }
}
