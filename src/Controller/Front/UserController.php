<?php

namespace App\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    // Log in route
    #[Route('/login', name: 'front_user_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        

        return $this->render('front/user/login.html.twig', [

        'last_username' => $lastUsername,
        'error'         => $error,
        ]);
    }

    // To show a user 
    #[Route('/profile', name: 'front_user_showProfile')]
    public function showProfile(): Response
    {
        // get the user connected
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // if the user does not exist 
        if ($user === null) {
            throw $this->createNotFoundException("L'utilisateur que vous cherchez n'existe pas.");
        }
        

        return $this->render('front/user/profile.html.twig', [

        'user' => $user,
        ]);
    }

    // To edit a user 

    // To delete a user 
}
