<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/back/home', name: 'back_home_index')]
    public function index(): Response
    {
        return $this->render('back/home/index.html.twig');
    }
}
