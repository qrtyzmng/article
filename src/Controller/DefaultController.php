<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Form\User\CommentType;

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
     * @Route("/article/{id}", name="default_article_show", methods={"GET", "POST"})
     */
    public function show(Article $article, Request $request, PaginatorInterface $paginator): Response
    {   
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $this->isGranted('ROLE_USER')) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setArticle($article);
            $comment->setUser($this->getUser());
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Created');
            $comment = new Comment();
            $form = $this->createForm(CommentType::class, $comment);
        }
        
        $entityManager = $this->getDoctrine()->getManager();
        $comments = $paginator->paginate(
            $entityManager->getRepository(Comment::class)->getLatest(),
            $request->query->getInt('page', 1),
            Comment::NUM_ITEMS
        );
        
        return $this->render('default/article/show.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'comments' => $comments,
            'image_directory' => basename($this->getParameter('image_directory')),
        ]);
    }
}
