<?php

namespace App\Controller\Front;

use App\Entity\Travel;
use App\Entity\Article;
use App\Form\Front\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    # To add an article related to a user travel
    #[Route('article/add/travel/{id}', name: 'front_article_add')]
    public function add(Travel $travel, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $article = new Article();

        $article->setTravel($travel);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $managerRegistry->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('front_travel_read', ['travel_id' => $travel->getId()]);
        }

        return $this->renderForm('front/travel/add_article.html.twig', [
            'travel' => $travel,
            'form' => $form,
        ]);
    }
}
