<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    public function registration(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator): Response
    {
        // user entity to create
        $user = new User();

        // create form
        $form = $this->createForm(UserType::class, $user);

        // request treatment by the form
        $form->handleRequest($request);

        // form validation
        if ($form->isSubmitted() && $form->isValid()) {

            // to automatically asigned user role
            $user->setRoles(['ROLE_USER']);

            // to hash password
            $password = $user->getPassword();

            $hashedPassword = $passwordHasher->hashPassword(
            // give the $user object to the hasher to know the encoding configuration in security.yaml
            $user,
            // need to get the password in the user entity
            $password,
            );

            // set the given password with hashed password
            $user->setPassword($hashedPassword);

            $errors = $validator->validate($user);
            $errorsList = [];
            if (count($errors) > 0) {

                /** @var ConstraintViolation $error */
                foreach($errors as $error) 
                {
                    $errorsList[$error->getPropertyPath()][] = $error->getMessage();

                }
                return $this->json([ 'errors' => $errorsList], Response::HTTP_UNPROCESSABLE_ENTITY); 
            }

            // use entity manager to persist and flush data in data base
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();

            // redirection
            return $this->redirectToRoute('front_main_home');
            }

        return $this->renderForm('front/main/registration.html.twig', [
            'form' => $form,
        ]);
    }

}
