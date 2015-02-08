<?php

namespace Projet\PhotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Achat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projet\PhotoBundle\Entity\AchatRepository")
 */
class Achat
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateAchat", type="datetime")
     */
    private $dateAchat;

    /**
     * @ORM\ManyToOne(targetEntity="Projet\PhotoBundle\Entity\Personne")
     * @ORM\JoinColumn(nullable=false)
     */
    private $personne;

    /**
     * @ORM\ManyToMany(targetEntity="Projet\PhotoBundle\Entity\Photo", cascade={"persist"})
     */
    private $photos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateAchat = new \DateTime();
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Get dateAchat
     *
     * @return \DateTime
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Set dateAchat
     *
     * @param \DateTime $dateAchat
     * @return Achat
     */
    public function setDateAchat($dateAchat)
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    /**
     * Get personne
     *
     * @return Projet\PhotoBundle\Entity\Personne
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Set personne
     *
     * @param Projet\PhotoBundle\Entity\Personne $personne
     */
    public function setPersonne(Projet\PhotoBundle\Entity\Personne $personne)
    {
        $this->personne = $personne;
    }

    /**
     * Add photos
     *
     * @param Projet\PhotoBundle\Entity\Photo $photos
     */
    public function addPhoto(Projet\PhotoBundle\Entity\Photo $photo)
    {
        $this->photos[] = $photo;
    }

    /**
     * Remove photos
     *
     * @param Projet\PhotoBundle\Entity\Photo $photos
     */
    public function removePhoto(Projet\PhotoBundle\Entity\Photo $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }
}
