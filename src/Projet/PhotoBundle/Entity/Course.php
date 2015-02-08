<?php

namespace Projet\PhotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projet\PhotoBundle\Entity\CourseRepository")
 */
class Course
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
     * @ORM\Column(name="nomCourse", type="string", length=255)
     */
    private $nomCourse;

    /**
     * @var float
     *
     * @ORM\Column(name="prixPhotoTTC", type="float")
     */
    private $prixPhotoTTC;

    /**
     * @ORM\OneToMany(targetEntity="Projet\PhotoBundle\Entity\Photo", mappedBy="course")
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
     * Get nomCourse
     *
     * @return string
     */
    public function getNomCourse()
    {
        return $this->nomCourse;
    }

    /**
     * Set nomCourse
     *
     * @param string $nomCourse
     * @return Course
     */
    public function setNomCourse($nomCourse)
    {
        $this->nomCourse = $nomCourse;

        return $this;
    }

    /**
     * Get prixPhotoTTC
     *
     * @return float
     */
    public function getPrixPhotoTTC()
    {
        return $this->prixPhotoTTC;
    }

    /**
     * Set prixPhotoTTC
     *
     * @param float $prixPhotoTTC
     * @return Course
     */
    public function setPrixPhotoTTC($prixPhotoTTC)
    {
        $this->prixPhotoTTC = $prixPhotoTTC;

        return $this;
    }

    /**
     * @return mixed
     */
    public function addPhoto(Projet\PhotoBundle\Entity\Photo $photo)
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
}
