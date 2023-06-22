<?php

namespace App\Controller\Front;

use App\Entity\Tip;
use App\Entity\Travel;
use App\Entity\Article;
use App\Entity\TipLike;
use App\Service\LikeManager;
use App\Repository\TipRepository;
use App\Repository\TipLikeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TipController extends AbstractController
{
    #[Route('/front/tips', name: 'front_tip_browse')]
    public function browse(TipRepository $tipRepository): Response
    {
        $user = $this->getUser();
        
        return $this->render('front/tip/browse.html.twig', [
            'tips' => $tipRepository->findBy([
                'user' => $user,
            ]),
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

    /**
     * To like or dislike a tip
     *
     * @param Tip $tip
     * @param ManagerRegistry $managerRegistry
     * @param TipLikeRepository $tipLikeRepository
     * @return Response
     */
    #[Route('/tip/{id}/like', name: 'front_tip_like')]
    public function like(Tip $tip, ManagerRegistry $managerRegistry, TipLikeRepository $tipLikeRepository) : Response 
    {
        $user = $this->getUser();

        // If the user is not connected
        if(!$user) {
            // return json with status code 403 and a message
            return $this->json(
                [
                   'code' => 403,
                   'message' => 'Unauthorized' 
                ],
                403 // real code (HTTP status)
                );
        }

        // If the user already likes the tip
        if($tip->isLikedByUser($user)) { 
            $like = $tipLikeRepository->findOneBy( // liked tip
                [
                    'tip' => $tip,
                    'user' => $user
                ]
                );
            
            // to delete the like and execute the request (save in BD)
            $em = $managerRegistry->getManager();
            $em->remove($like);
            $em->flush();

            // return a json with status code, a massage and the number of likes on the tip
            return $this->json(
                [
                   'code' => 200,
                   'message' => 'Like deleted',
                   'likes' => $tipLikeRepository->count(['tip' => $tip])
                ],
                200
                );
        }

        // If the user wants like the tip
        $like = new TipLike;
        $like->setTip($tip);
        $like->setUser($user);

        $em = $managerRegistry->getManager();
        $em->persist($like);
        $em->flush();

        return $this->json(
            [
               'code' => 200,
               'message' => 'Like added',
               'likes' => $tipLikeRepository->count(['tip' => $tip])
            ],
            200
            );

        
    }
}
