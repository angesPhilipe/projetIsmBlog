<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_ADMIN")
*/
class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/show/{id?}", name="categorie_show", methods={"GET"})
     */
    #on peut ajouter un methode :=> methods={"POST","GET"} elle sera accessible par les 2
    public function show($id, CategorieRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        $categories=$repo->findAll();
        
        //gestion formulaire mode modif
        if (!empty ($id)) {
            $categorie=$repo->find($id);
        }else{
            //gestion formulaire mode ajout
            $categorie=new Categorie();
        }


        $form=$this->createForm(CategorieType::class, $categorie);
        //recupération $_POST['name]
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);
            $manager->flush();
            return $this->redirectToRoute("categorie_show");
        }


        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView()
            
            #pour transporter une valeur d'ici à la vue on utilise le tableau au dessus
            #dans la vue on l'affiche à l'aide de : {{x}}
            #transport de la vue à ici regard video 2eme cours 4h15min
            #pour mettre des if ou for video 3eme cours part 1 a 21min
            #pour creer la base de donnée 2em cours part 1 à 1h15min
        ]);
    }


    /**
     * @Route("/categorie/add", name="categorie_add", methods={"POST"})
     */
    public function add(): Response{
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }


    /**
     * @Route("/categorie/update", name="categorie_add", methods={"POST"})
     */
    public function update(): Response{
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }


    /**
     * @Route("/categorie/delete/{id}", name="categorie_delate", methods={"GET"})
     */
    public function delete($id,CategorieRepository $repo,EntityManagerInterface $manager): Response{
        
        $categorie=$repo->find($id);
        $manager->remove($categorie);
        $manager->flush();
        return $this->redirectToRoute("categorie_show");
    }
}
