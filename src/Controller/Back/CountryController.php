<?php

namespace App\Controller\Back;

use App\Service\restCountriesAPI;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryController extends AbstractController
{
    private $restCountriesAPI;

    public function __construct(restCountriesAPI $restCountriesAPI) {
        $this->restCountriesAPI = $restCountriesAPI;
    }

    #[Route('/back/countries', name: 'back_country_browse')]
    public function browse(): JsonResponse
    {
        $countriesInfo = $this->restCountriesAPI->fetchAll();

        $test = "ma variable transmise";

       return $this->render('front/travel/add.html.twig', [
        'test' => $test
       ]);

    }


    #[Route('/back/country', name: 'back_country_show')]
    public function show(): JsonResponse
    {
        $countryInfo = $this->restCountriesAPI->fetch('France');

        dd($countryInfo);
    }
}
