<?php

namespace Projet\PhotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personne
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projet\PhotoBundle\Entity\PersonneRepository")
 */
class Personne
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text")
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\OneToMany(targetEntity="Projet\PhotoBundle\Entity\Photo", mappedBy="photo")
     */
    private $photos;


    public function __construct()
    {
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
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Personne
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Personne
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Personne
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Personne
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Personne
     */
    public function setDateNaissance(\DateTime $dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return mixed
     */
    public function addPhoto(\Projet\PhotoBundle\Entity\Photo $photo)
    {
        $this->photos[] = $photo;
        $photo->setCourse($this);
        return $this;
    }

    /**
     * @param mixed $photo
     */
    public function removePhoto(\Projet\PhotoBundle\Entity\Photo $photo)
    {
        $this->photos->removeElement($photo);
        return $this;
    }

    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * fills a new entity with rows from CSV File
     */
    public function fill($row)
    {
        $this->setNom($row[2]);
        $this->setPrenom($row[3]);
        $this->setDateNaissance(\DateTime::createFromFormat('d/m/Y', $row[10]));
        $this->setAdresse($row[5] . ', ' . $row[6] . ' ' . $row[7]);
        $this->setEmail($row[9]);
    }
}
