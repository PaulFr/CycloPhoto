<?php

namespace Projet\PhotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projet\PhotoBundle\Entity\PhotoRepository")
 */
class Photo
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
     * @ORM\ManyToOne(targetEntity="Projet\PhotoBundle\Entity\Course", inversedBy="photos", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="Projet\PhotoBundle\Entity\Personne", fetch="EAGER")
     */
    private $personne;


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
     * Get course
     *
     * @return \Projet\PhotoBundle\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set course
     *
     * @param \Projet\PhotoBundle\Entity\Course $course
     */
    public function setCourse(\Projet\PhotoBundle\Entity\Course $course)
    {
        $this->course = $course;
    }

    /**
     * get Personne
     * @return \Projet\PhotoBundle\Entity\Personne
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * set Personne
     * @param \Projet\PhotoBundle\Entity\Personne $personne
     */
    public function setPersonne(\Projet\PhotoBundle\Entity\Personne $personne)
    {
        $this->personne = $personne;
    }
}
