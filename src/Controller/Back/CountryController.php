<?php

namespace App\Controller\Back;

use App\Service\restCountriesAPI;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryController extends AbstractController
{
    private $restCountriesAPI;

    public function __construct(restCountriesAPI $restCountriesAPI) {
        $this->restCountriesAPI = $restCountriesAPI;
    }

    #[Route('/api/countries', name: 'back_country_browse')]
    public function browse(): JsonResponse
    {
        $countriesInfo = new JsonResponse( $this->restCountriesAPI->fetchAll());

        return $countriesInfo;

    }
}
