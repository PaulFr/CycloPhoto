<?php

namespace Projet\PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PhotosController extends Controller
{

    public function afficherAction($id, $key)
    {
        return $this->render("ProjetPhotoBundle:Photos:afficher.html.twig");
    }

} 