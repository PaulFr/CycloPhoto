<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 13/02/2015
 * Time: 08:24
 */

namespace Projet\PhotoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

    public function indexAction()
    {
        return $this->render("ProjetPhotoBundle:Admin:index.html.twig");
    }

} 