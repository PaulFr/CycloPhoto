<?php

namespace projetPhoto\CycloPhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('projetPhotoCycloPhotoBundle:Default:index.html.twig', array('name' => $name));
    }

    public function contentAction() {
        return $this->render('projetPhotoCylcoPhotoBundle:Default:content.html.twig');
    }
}
