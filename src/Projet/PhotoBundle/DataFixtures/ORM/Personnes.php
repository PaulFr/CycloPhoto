<?php

namespace Projet\PhotoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use  Projet\PhotoBundle\Entity\Personne;

class Personnes implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {

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
        );

        foreach ($personnes as $personne) {

            $p = new Personne();
            $p->setNom($personne['nom']);
            $p->setPrenom($personne['prenom']);
            $p->setAdresse($personne['adresse']);
            $p->setEmail($personne['email']);
            $p->setDateNaissance($personne['date']);

            $manager->persist($p);
        }

        $manager->flush();
    }
}