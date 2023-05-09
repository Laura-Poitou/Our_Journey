<?php

namespace App\Controller\Front;

use App\Entity\Travel;
use App\Entity\Traveler;
use App\Form\TravelType;
use App\Repository\TravelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TravelController extends AbstractController
{
    # To show all travels
    #[Route('/travels', name: 'front_travel_browse')]
    public function browse(TravelRepository $travelRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('front/travel/browse.html.twig', [
            'travels' => $travelRepository->findAllByUser($user)
        ]);
    }

    # To add a travel
    #[Route('/travels/add', name: 'front_travel_add')]
    public function add(TravelRepository $travelRepository, Request $request): Response
    {
        $travel = new Travel();

        $traveler = new Traveler();
        $traveler->setName('voyageur1');

        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \App\Entity\User $user */
            $user = $this->getUser();

            $travel->addUser($user);

            $travelRepository->save($travel, true);

            return $this->redirectToRoute('front_travel_browse',  [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/travel/add.html.twig', [
            'form' => $form
        ]);
    }

    # To show all articles related to a user travel
    #[Route('/travels/{travel_id}', name: 'front_travel_read')]
    #[ParamConverter('travel', options: ['mapping' => ['travel_id' => 'id']])]
    public function read(TravelRepository $travelRepository, Travel $travel): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('front/travel/read.html.twig', [
            'articles' => $travelRepository->findTravelAndArticles($user, $travel),
            'travel' => $travel
        ]);
    }

}
