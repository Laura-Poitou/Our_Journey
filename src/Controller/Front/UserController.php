<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    #[Route('/profile/edit', name: 'front_user_editProfile')]
    public function editProfile(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        // get the user connected
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // persist and flush data
            $userRepository->save($user, true);

            return $this->redirectToRoute('front_user_showProfile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/user/editProfile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // To edit user password 
    #[Route('/profile/edit/password', name: 'front_user_editPassword')]
    public function editPassword(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        // get the user connected
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //get the new password
            $newPassword = $form->get('password')->getData();
         
            $hashedPassword = $passwordHasher->hashPassword(
                // pass $user object permit to the hasher to know the encode mode configured in security.yaml 
                $user,
                $newPassword,
            );

            // replace clear password with hashed one 
            $user->setPassword($hashedPassword);

            // persist and flush data
            $userRepository->save($user, true);

            return $this->redirectToRoute('front_user_showProfile', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/user/editPassword.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // To delete a user 
    #[Route('/profile/delete', name: 'front_user_deleteProfile')]
    public function deleteProfile(Request $request, UserRepository $userRepository): Response
    {
        // get the user connected
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // protection against csrf attack
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            // delete and flush
            $userRepository->remove($user, true);
        }

        // before redirection -> have to invalidate session
        $request->getSession()->invalidate();
        $this->container->get('security.token_storage')->setToken(null);

        return $this->redirectToRoute('front_main_registration', [], Response::HTTP_SEE_OTHER);
    }
}
