<?php

namespace App\Controller\Front;

use App\Entity\Travel;
use App\Repository\TravelRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
