<?php

namespace Projet\PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Projet\PhotoBundle\Model\Panier;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProjetPhotoBundle:Default:content.html.twig');
    }


    public function panierAction()
    {
        $panier = new Panier();


        return $this->render('ProjetPhotoBundle:Default:panier.html.twig', array('panier' => $panier));
    }

}
