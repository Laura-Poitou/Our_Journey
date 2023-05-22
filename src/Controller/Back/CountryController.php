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


    #[Route('/back/country', name: 'back_country_show')]
    public function show(): JsonResponse
    {
        $countryInfo = $this->restCountriesAPI->fetch('France');

        dd($countryInfo);
    }
}
