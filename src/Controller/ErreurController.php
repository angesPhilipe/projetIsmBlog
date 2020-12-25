<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErreurController extends AbstractController
{
    /**
     * @Route("/error/403", name="error_403")
     */
    public function error_403(): Response
    {
        return $this->render('erreur/403.html.twig', [
            'controller_name' => 'ErreurController',
        ]);
    }
}
