<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/show/{id?}", name="article_show", methods={"POST","GET"})
     */
    public function show($id, ArticleRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $articles=$repo->findall();
        
        if (!empty ($id)) {
            $article=$repo->find($id);
        }else{
            $article=new Article();
        }
        


        $form=$this->createForm(ArticleType::class, $article);
        //recupération $_POST['name]
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute("article_show");
        }
        
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView() ]);


    
    }

    



    /**
     * @Route("/article/categorie/{categorieId}", name="article_by_categorie", methods={"GET"})
     */
    public function showArticleByCategorie($categorieId,ArticleRepository $repo,CategorieRepository $repos,EntityManagerInterface $manager): Response
    {
        $categorie =$repos->find($categorieId);

        $articles=$repo->findBy(array("categorie" => $categorie));
        


        return $this->render('article/articles.html.twig', [
            'articles' => $articles ]);
        
    }

    


    /**
     * @Route("/article/delete/{id}/{catId}", name="article_delate", methods={"GET"})
     */
    public function delete($id,$catId,ArticleRepository $repo,EntityManagerInterface $manager): Response{
        $article=$repo->find($id);
        $manager->remove($article);
        $manager->flush();
        return $this->redirectToRoute("article_show");
    }
}


