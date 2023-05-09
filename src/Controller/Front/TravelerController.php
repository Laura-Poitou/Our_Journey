<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TravelerController extends AbstractController
{
    #[Route('/front/traveler', name: 'app_front_traveler')]
    public function index(): Response
    {
        return $this->render('front/traveler/index.html.twig', [
            'controller_name' => 'TravelerController',
        ]);
    }
}
