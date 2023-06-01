<?php

namespace App\Controller\Back;

use App\Entity\Travel;
use App\Form\Back\TravelType;
use App\Service\geocodingAPI;
use App\Repository\UserRepository;
use App\Repository\TravelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/back/travel')]
class TravelController extends AbstractController
{
    #[Route('/', name: 'app_back_travel_index', methods: ['GET'])]
    public function index(TravelRepository $travelRepository): Response
    {
        return $this->render('back/travel/index.html.twig', [
            'travel' => $travelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_travel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TravelRepository $travelRepository, UserRepository $userRepository, geocodingAPI $geocodingAPI): Response
    {
        $travel = new Travel();
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $users = $travel->getUsers();
            foreach($users as $user) {
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

                // to retrieve informations from API for each destination choose by user and retrieve to the new travel
                $destinationNameArray = [];
                $destinationsInfoArray = [];
                foreach($travelDestinations as $destination) {
                    $destinationNameArray[] = $destination->getName();
                    foreach($destinationNameArray as $destinationName) {
                        $destinationsInfoArray[] = $geocodingAPI->fetch("$destinationName");
                    }
                }

                // to set latitude and longitude for each destination choose by user
                foreach($travelDestinations as $travelDestination) {
                    foreach($destinationsInfoArray as $destination) {
                        $destinationName = $destination[0]['name'];
                        $destinationLatitude = $destination[0]["lat"];
                        $destinationLongitude = $destination[0]["lon"];
                        if($travelDestination->getName() == $destinationName) {
                            $travelDestination->setLatitude($destinationLatitude);
                            $travelDestination->setLongitude($destinationLongitude);
                        }
                    }
                }
                // persist and flush
                $userRepository->save($user, true);
            }

            $travelRepository->save($travel, true);
           

            return $this->redirectToRoute('app_back_travel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/travel/new.html.twig', [
            'travel' => $travel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_travel_show', methods: ['GET'])]
    public function show(Travel $travel): Response
    {
        return $this->render('back/travel/show.html.twig', [
            'travel' => $travel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_travel_edit', methods: ['GET', 'POST'])]
    public function edit(TravelRepository $travelRepository, Request $request, UserRepository $userRepository, geocodingAPI $geocodingAPI, Travel $travel = null): Response
    {
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $travel->getUsers();
            foreach($users as $user) {
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

                // to retrieve informations from API for each destination choose by user and retrieve to the new travel
                $destinationNameArray = [];
                $destinationsInfoArray = [];
                foreach($travelDestinations as $destination) {
                    $destinationNameArray[] = $destination->getName();
                    foreach($destinationNameArray as $destinationName) {
                        $destinationsInfoArray[] = $geocodingAPI->fetch("$destinationName");
                    }
                }

                // to set latitude and longitude for each destination choose by user
                foreach($travelDestinations as $travelDestination) {
                    foreach($destinationsInfoArray as $destination) {
                        $destinationName = $destination[0]['name'];
                        $destinationLatitude = $destination[0]["lat"];
                        $destinationLongitude = $destination[0]["lon"];
                        if($travelDestination->getName() == $destinationName) {
                            $travelDestination->setLatitude($destinationLatitude);
                            $travelDestination->setLongitude($destinationLongitude);
                        }
                    }
                }
                // persist and flush
                $userRepository->save($user, true);
            }

            $travelRepository->save($travel, true);

            return $this->redirectToRoute('app_back_travel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/travel/edit.html.twig', [
            'travel' => $travel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_travel_delete', methods: ['POST'])]
    public function delete(Request $request, Travel $travel, TravelRepository $travelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$travel->getId(), $request->request->get('_token'))) {
            $travelRepository->remove($travel, true);
        }

        return $this->redirectToRoute('app_back_travel_index', [], Response::HTTP_SEE_OTHER);
    }
}
