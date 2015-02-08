<?php

namespace projetPhoto\CycloPhotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="projetPhoto\CycloPhotoBundle\Entity\CourseRepository")
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
}
