<?php

namespace Projet\PhotoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use  Projet\PhotoBundle\Entity\Course;

class Courses implements FixtureInterface
{

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

        foreach ($courses as $course) {

            $p = new Course();
            $p->setNomCourse($course['nom']);
            $p->setPrixPhotoTTC($course['prix']);

            $manager->persist($p);
        }

        $manager->flush();
    }
}