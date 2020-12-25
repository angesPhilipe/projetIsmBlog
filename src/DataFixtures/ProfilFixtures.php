<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $libelles=[
            "Admin",
            "Redacteur",
            "Lecteur"
        ];
        foreach ($libelles as $key => $libelle) {
            $profil=new Profil();
            $profil->setLibelle($libelle);
            $manager->persist($profil);
        }

        $manager->flush();
    }
}
