<?php

namespace projetPhoto\CycloPhotoBundle\Model;
/**
 * Created by PhpStorm.
 * User: Gaëtan
 * Date: 05/02/2015
 * Time: 10:58
 */
class Panier
{
    private $nombreProduit;
    private $produits;
    private $prixTotal;

    function __construct()
    {
        $this->nombreProduit = 3;
        $this->produits = array();
        $this->prixTotal = 10;

        array_push($this->produits, 'produit 1');
        array_push($this->produits, 'produit 2');
        array_push($this->produits, 'produit 3');
    }

    /**
     * @return int
     */
    public function getNombreProduit()
    {
        return $this->nombreProduit;
    }

    /**
     * @return int
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    /**
     * @return array
     */
    public function getProduits()
    {
        return $this->produits;
    }


}
