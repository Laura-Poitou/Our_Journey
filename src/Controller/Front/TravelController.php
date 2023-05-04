<?php

namespace App\Controller\Front;

use App\Repository\TravelRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
}
