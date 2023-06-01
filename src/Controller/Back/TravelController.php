<?php

namespace App\Controller\Back;

use App\Entity\Travel;
use App\Form\Back\TravelType;
use App\Repository\TravelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/travel')]
class TravelController extends AbstractController
{
    #[Route('/', name: 'app_back_travel_index', methods: ['GET'])]
    public function index(TravelRepository $travelRepository): Response
    {
        return $this->render('back/travel/index.html.twig', [
            'travel' => $travelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_travel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TravelRepository $travelRepository): Response
    {
        $travel = new Travel();
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travelRepository->save($travel, true);

            return $this->redirectToRoute('app_back_travel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/travel/new.html.twig', [
            'travel' => $travel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_travel_show', methods: ['GET'])]
    public function show(Travel $travel): Response
    {
        return $this->render('back/travel/show.html.twig', [
            'travel' => $travel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_travel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Travel $travel, TravelRepository $travelRepository): Response
    {
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $travelRepository->save($travel, true);

            return $this->redirectToRoute('app_back_travel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/travel/edit.html.twig', [
            'travel' => $travel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_travel_delete', methods: ['POST'])]
    public function delete(Request $request, Travel $travel, TravelRepository $travelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$travel->getId(), $request->request->get('_token'))) {
            $travelRepository->remove($travel, true);
        }

        return $this->redirectToRoute('app_back_travel_index', [], Response::HTTP_SEE_OTHER);
    }
}
