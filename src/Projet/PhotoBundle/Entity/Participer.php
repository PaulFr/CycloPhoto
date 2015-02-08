<?php

namespace projetPhoto\CycloPhotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="projetPhoto\CycloPhotoBundle\Entity\ParticiperRepository")
 */
class Participer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="numDossard", type="integer")
     */
    private $numDossard;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get numDossard
     *
     * @return integer
     */
    public function getNumDossard()
    {
        return $this->numDossard;
    }

    /**
     * Set numDossard
     *
     * @param integer $numDossard
     * @return Participer
     */
    public function setNumDossard($numDossard)
    {
        $this->numDossard = $numDossard;

        return $this;
    }
}
