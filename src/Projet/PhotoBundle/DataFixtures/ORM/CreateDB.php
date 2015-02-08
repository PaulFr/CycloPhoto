<?php
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 08/02/2015
 * Time: 16:16
 */

namespace Projet\PhotoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Projet\PhotoBundle\Entity\Participer;
use  Projet\PhotoBundle\Entity\Personne;
use  Projet\PhotoBundle\Entity\Course;
use Projet\PhotoBundle\Entity\Photo;
use Symfony\Component\Security\Core\Util\SecureRandom;

class CreateDB implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $courses = array(
            array(
                "nom" => "Course de ouf",
                "prix" => 12,
            ),
            array(
                "nom" => "Sous la pluie",
                "prix" => 5,
            ),
        );

        $personnes = array(
            array(
                "nom" => "Honzga",
                "prenom" => "Michel",
                "adresse" => "Rue des paquerettes, 34090 Montpellier",
                "email" => "hmichel@gmail.com",
                "date" => new \DateTime(),
            ),
            array(
                "nom" => "Gadou",
                "prenom" => "Cyril",
                "adresse" => "Rue des oliviers, 34500 Béziers",
                "email" => "cycy478@hotmail.com",
                "date" => new \DateTime(),
            ),
            array(
                "nom" => "Lousteau",
                "prenom" => "Romain",
                "adresse" => "Avenue St-Priest, 64400 Oloron",
                "email" => "rom@outlook.com",
                "date" => new \DateTime(),
            ),
        );

        $listePersonnes = array();
        $listeCourses = array();

        foreach ($courses as $course) {

            $p = new Course();
            $p->setNomCourse($course['nom']);
            $p->setPrixPhotoTTC($course['prix']);

            $listeCourses[] = $p;

            $manager->persist($p);
        }

        foreach ($personnes as $personne) {

            $p = new Personne();
            $p->setNom($personne['nom']);
            $p->setPrenom($personne['prenom']);
            $p->setAdresse($personne['adresse']);
            $p->setEmail($personne['email']);
            $p->setDateNaissance($personne['date']);

            $listePersonnes[] = $p;

            $manager->persist($p);
        }
        $manager->flush();

        $participation = new Participer();
        $participation->setCourse($listeCourses[1]);
        $participation->setPersonne($listePersonnes[0]);
        $participation->setNumDossard(1);
        $generator = new SecureRandom();
        $participation->setCodeUnique($generator->nextBytes(10));

        $manager->persist($participation);

        $participation = new Participer();
        $participation->setCourse($listeCourses[0]);
        $participation->setPersonne($listePersonnes[1]);
        $participation->setNumDossard(1);
        $participation->setCodeUnique($generator->nextBytes(10));

        $manager->persist($participation);

        $participation = new Participer();
        $participation->setCourse($listeCourses[0]);
        $participation->setPersonne($listePersonnes[2]);
        $participation->setNumDossard(1);
        $participation->setCodeUnique($generator->nextBytes(10));

        $manager->persist($participation);

        $photo = new Photo();
        $photo->setCourse($listeCourses[1]);
        $photo->setPersonne($listePersonnes[0]);
        $manager->persist($photo);
        $photo = new Photo();
        $photo->setCourse($listeCourses[1]);
        $photo->setPersonne($listePersonnes[0]);
        $manager->persist($photo);
        $photo = new Photo();
        $photo->setCourse($listeCourses[0]);
        $photo->setPersonne($listePersonnes[1]);
        $manager->persist($photo);
        $photo = new Photo();
        $photo->setCourse($listeCourses[0]);
        $photo->setPersonne($listePersonnes[1]);
        $manager->persist($photo);
        $photo = new Photo();
        $photo->setCourse($listeCourses[0]);
        $photo->setPersonne($listePersonnes[1]);
        $manager->persist($photo);
        $photo = new Photo();
        $photo->setCourse($listeCourses[0]);
        $photo->setPersonne($listePersonnes[2]);
        $manager->persist($photo);

        $manager->flush();

    }
}