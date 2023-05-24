<?php

namespace App\Controller\Front;

use App\Entity\Travel;
use App\Entity\Traveler;
use App\Form\TravelType;
use App\Service\restCountriesAPI;
use App\Repository\UserRepository;
use App\Repository\TravelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TravelController extends AbstractController
{
    # To show all travels
    #[Route('/travels', name: 'front_travel_browse')]
    public function browse(TravelRepository $travelRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('front/travel/browse.html.twig', [
            'travels' => $travelRepository->findAllByUser($user)
        ]);
    }

    # To add a travel
    #[Route('/travels/add', name: 'front_travel_add')]
    public function add(TravelRepository $travelRepository, Request $request, UserRepository $userRepository, restCountriesAPI $restCountriesAPI): Response
    {
        $travel = new Travel();

        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var \App\Entity\User $user */
            $user = $this->getUser();

            // add new travel to the connected user
            $travel->addUser($user);

            // to have travelers
            $travelTravelers = $travel->getTravelers();
            
            // Associative table of user travelers
            $userTravelersList = $userRepository->getUserTravelers($user);
            
            // Create table with user travelers name 
            $userTravelersName = [];
            foreach ($userTravelersList as $userTraveller) {
                $userTravelersName[] = $userTraveller['name'];
            }

            // for each traveler of the travel
            foreach ($travelTravelers as $traveler) {
                // if the new traveler name is not in user traveler list add it 
                if(!in_array($traveler->getName(), $userTravelersName)) {
                    $user->addTraveler($traveler);
                }
            }

            // to have destinations
            $travelDestinations = $travel->getDestinations();
            
                     
            //persist and flush
            $travelRepository->save($travel, true);

            // persist and flush
            $userRepository->save($user, true);

            return $this->redirectToRoute('front_travel_browse',  [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('front/travel/add.html.twig', [
            'form' => $form,
            'data' => $restCountriesAPI->fetchAll(),
        ]);
    }

    # To show all articles related to a user travel
    #[Route('/travels/{travel_id}', name: 'front_travel_read')]
    #[ParamConverter('travel', options: ['mapping' => ['travel_id' => 'id']])]
    public function read(TravelRepository $travelRepository, Travel $travel, UserRepository $userRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('front/travel/read.html.twig', [
            'articles' => $travelRepository->findTravelAndArticles($user, $travel),
            'travel' => $travel,
            'destinations' => $travelRepository->findTravelDestinations($user, $travel)
        ]);
    }

    // To delete a travel 
    #[Route('/travel/delete/{travel_id}', name: 'front_travel_delete')]
    #[ParamConverter('travel', options: ['mapping' => ['travel_id' => 'id']])]
    public function delete(Request $request, TravelRepository $travelRepository, Travel $travel): Response
    {
        // protection against csrf attack
        if ($this->isCsrfTokenValid('delete'.$travel->getId(), $request->request->get('_token'))) {
            // delete and flush
            $travelRepository->remove($travel, true);
        }

        return $this->redirectToRoute('front_travel_browse', [], Response::HTTP_SEE_OTHER);
    }

}
