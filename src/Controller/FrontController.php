<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/front")
 */
class FrontController extends AbstractController
{
    /**
     * @Route("/show", name="front")
     */
    public function index(ArticleRepository $repo): Response
    {
        $article = $repo->findby([
            "isEtat" => "publier"
        ]);

        return $this->render('front/index.html.twig', [
            'articles' => $article
        ]);
    }

    /**
     * @Route("front/detail_article/{id?}", name="front_detail_article", methods={"GET"})
     */
    public function detail_article(Article $article,ArticleRepository $repo): Response
    {
        return $this->render('front/detail_article.html.twig', [
            'article' => $article
        ]);
    }

    
}
