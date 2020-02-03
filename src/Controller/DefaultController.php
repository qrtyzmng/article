<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $articles = $paginator->paginate(
            $entityManager->getRepository(Article::class)->getLatest(),
            $request->query->getInt('page', 1),
            Article::NUM_ITEMS
        );
        
        return $this->render('default/index.html.twig', [
            'articles' => $articles
        ]);
    }
    
    /**
     * @Route("/article/{id}", name="default_article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('default/article/show.html.twig', [
            'article' => $article,
            'image_directory' => basename($this->getParameter('image_directory'))
        ]);
    }
}
