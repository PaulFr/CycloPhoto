<?php

namespace projetPhoto\CycloPhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('projetPhotoCycloPhotoBundle:Default:content.html.twig');
    }

    public function panierAction()
    {
        require_once('Panier.php');
        $panier = new \Panier();

        return $this->render('projetPhotoCycloPhotoBundle:Default:panier.html.twig', array('panier' => $panier));
    }
}
