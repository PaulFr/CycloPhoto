<?php

namespace Projet\PhotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projet\PhotoBundle\Entity\ParticiperRepository")
 */
class Participer
{
    /**
     * @ORM\ManyToOne(targetEntity="Projet\PhotoBundle\Entity\Personne")
     * @ORM\Id
     */
    private $personne;

    /**
     * @ORM\ManyToOne(targetEntity="Projet\PhotoBundle\Entity\Course")
     * @ORM\Id
     */
    private $course;

    /**
     * @var integer
     *
     * @ORM\Column(name="numDossard", type="integer")
     */
    private $numDossard;

    /**
     * @var string
     *
     * @ORM\Column(name="codeUnique", type="string", length=255)
     */
    private $codeUnique;


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

    /**
     * @return string
     */
    public function getCodeUnique()
    {
        return $this->codeUnique;
    }

    /**
     * @param string $codeUnique
     */
    public function setCodeUnique($codeUnique)
    {
        $this->codeUnique = $codeUnique;
    }

    /**
     * @return mixed
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * @param mixed $personne
     */
    public function setPersonne(\Projet\PhotoBundle\Entity\Personne $personne)
    {
        $this->personne = $personne;
    }

    /**
     * @return mixed
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse(\Projet\PhotoBundle\Entity\Course $course)
    {
        $this->course = $course;
    }
}
