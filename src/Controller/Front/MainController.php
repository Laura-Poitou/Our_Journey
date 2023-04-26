<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    // Home page
    #[Route('/', name: 'front_main_home')]
    public function home(): Response
    {
        return $this->render('front/main/home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    // Registration page
    #[Route('/inscription', name: 'front_main_registration')]
    public function registration(Request $request, ManagerRegistry $managerRegistry): Response
    {
        // user entity to create
        $user = new User();

        // create form
        $form = $this->createForm(UserType::class, $user);

        // request treatment by the form
        $form->handleRequest($request);

        // form validation
        if ($form->isSubmitted() && $form->isValid()) {

            // user entity manager to persist and flush data in data base
            $em = $managerRegistry->getManager();
            $em->persist($review);
            $em->flush();

            // redirection
            return $this->redirectToRoute('front_main_home');
            }

        return $this->renderForm('front/main/registration.html.twig', [
            'form' => $form,
        ]);
    }

}
