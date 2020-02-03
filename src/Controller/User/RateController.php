<?php

namespace App\Controller\User;

use App\Entity\Rate;
use App\Form\User\RateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;

/**
 * @Route("/user/rate")
 */
class RateController extends AbstractController
{
    /**
     * @Route("/{id}/new", name="user_rate_new", methods={"GET","POST"})
     */
    public function new(Article $article, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $currentUser = $this->getUser();
        $oldRate = $entityManager->getRepository(Rate::class)->findOneBy([
            "user" => $currentUser->getId(),
            "article" => $article->getId(),
        ]);
        
        if (!empty($oldRate)) {
            $this->addFlash('danger', 'You already rated this article');
            return $this->redirectToRoute('default_article_show', ['id' => $article->getId()]);
        }
        
        $rate = new Rate();
        $form = $this->createForm(RateType::class, $rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $rate->setArticle($article);
            $rate->setUser($currentUser);
            $entityManager->persist($rate);
            $entityManager->flush();
            
            $currentRate = $entityManager->getRepository(Rate::class)->getSumValuesByArticle($article);
            $article->setRate($currentRate['value']/$currentRate['amount']);
            
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('default_article_show', ['id' => $article->getId()]);
        }
        
        return $this->render('user/rate/new.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
        ]);
    }
}
