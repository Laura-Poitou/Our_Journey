<?php

namespace App\Controller\Back;

use App\Service\geocodingAPI;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CityController extends AbstractController
{
    #[Route('/back/cities', name: 'back_city_browse')]
    public function browse(geocodingAPI $geocodingAPI): Response
    {

        dd($geocodingAPI->fetch('Florence'));

        // return $this->render('back/countries.html.twig', [
        //     'data' => $geocodingAPI->fetch(),
        // ]);

    }
}
