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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_REDACTEUR")
*/
class ArticleController extends AbstractController
{
    /**
     * @Route("/article/show", name="article_show", methods={"POST","GET"})
     */
    public function show(ArticleRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$this->isGranted("ROLE_REDACTEUR")) {
            return $this->redirectToRoute("erreur_403");
        }
        $articles=$repo->findall();
        
        return $this->render('article/index.html.twig', [
            'articles' => $articles ]);


    
    }

    



    /**
     * @Route("/article/categorie/{categorieId}", name="article_by_categorie", methods={"POST","GET"})
     */
    public function showArticleByCategorie($categorieId,ArticleRepository $repo,EntityManagerInterface $manager): Response
    {
        $article =$repo->findby([
            "categorie"=>$categorieId
            ]);

        return $this->render('article/index.html.twig', [
            'articles' => $article ]);
        
    }

    


    /**
     * @Route("/article/delete/{id}", name="article_delate", methods={"GET"})
     */
    public function delete($id,ArticleRepository $repo,EntityManagerInterface $manager): Response{
        $article=$repo->find($id);
        $manager->remove($article);
        $manager->flush();
        return $this->redirectToRoute("article_show");
    }



    
    #cest la meme chose que celui du haut
        #public function delete(Article $article,ArticleRepository $repo,EntityManagerInterface $manager): Response{
            #$manager->remove($article);
            #$manager->flush();
        #return $this->redirectToRoute("article_show");}

     /**
     * @Route("/article/add/{id?}", name="article_add", methods={"POST","GET"})
     */
    public function save($id,ArticleRepository $repo,EntityManagerInterface $manager, Request $request): Response{
        $article = empty($id)? new Article():$repo->find($id) ;
        $form=$this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute("article_show");
        }
        return $this->render('article/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/showArticleByStatut/{statut}", name="article_by_statut", methods={"POST","GET"})
     */
    public function showArticleByStatut($statut,ArticleRepository $repo,EntityManagerInterface $manager): Response
    {
        $article =$repo->findBy([
            "isEtat"=>$statut
        ]);
        return $this->render('article/index.html.twig', [
            'articles' => $article ]);
        
    }
}


