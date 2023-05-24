<?php

namespace App\Controller\Back;

use App\Service\restCountriesAPI;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryController extends AbstractController
{
    
    #[Route('/back/countries', name: 'back_country_browse')]
    public function browse(restCountriesAPI $restCountriesAPI): Response
    {

        //dd($restCountriesAPI->fetchAll());

        return $this->render('back/countries.html.twig', [
            'data' => $restCountriesAPI->fetchAll(),
        ]);

    }
}
