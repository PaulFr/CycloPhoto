<?php

namespace projetPhoto\CycloPhotoBundle\Controller;

use projetPhoto\CycloPhotoBundle\Model\Panier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('projetPhotoCycloPhotoBundle:Default:content.html.twig');
    }

    public function panierAction()
    {
        $panier = new Panier();


        return $this->render('projetPhotoCycloPhotoBundle:Default:panier.html.twig', array('panier' => $panier));
    }
}
