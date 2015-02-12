<?php

namespace Projet\PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProjetPhotoBundle:Default:content.html.twig');
    }



}
