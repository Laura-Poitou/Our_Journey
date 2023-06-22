<?php

namespace App\Controller\Front;

use App\Entity\Tip;
use App\Entity\Travel;
use App\Entity\Article;
use App\Service\LikeManager;
use App\Repository\TipRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TipController extends AbstractController
{
    #[Route('/front/tip', name: 'app_front_tip')]
    public function index(): Response
    {
        return $this->render('front/tip/index.html.twig', [
            'controller_name' => 'TipController',
        ]);
    }

    # To add or remove like on tip
    #[Route('/travel/{travel_id}/article/{article_id}/toggle/{id}', name: 'front_tip_toggle')]
    #[ParamConverter('travel', options: ['mapping' => ['travel_id' => 'id']])]
    #[ParamConverter('article', options: ['mapping' => ['article_id' => 'id']])]
    public function toggle(Tip $tip, TipRepository $tipRepository, Travel $travel, Article $article, LikeManager $likeManager, ParameterBagInterface $parameterBag): Response
    {
        // on appelle la méthode toggle() de notre service
        $added = $likeManager->toggle($tip);

        $likeNumber = $tip->getLikeNumber();

        if ($added === true) {
            $tip->setLikeNumber($likeNumber + 1);
            $tipRepository->save($tip, true);
        } else {
            $tip->setLikeNumber($likeNumber - 1);
            $tipRepository->save($tip, true);
        }

        // redirection to list of liked tips
        return $this->redirectToRoute('front_travel_readArticle', array(
            'travel_id' => $travel->getId(),
            'id' => $article->getId(),
        ));
    }
}
