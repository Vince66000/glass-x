<?php

namespace App\DataFixtures;

use App\Entity\Artwork;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArtworkFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i=0; $i < 50; $i++) {

            $artwork = new Artwork();
            $artwork
                ->setNom('Ma super toile '.($i +1))
                ->setType(1)
                ->setLongueur(50)
                ->setLargeur(80)
                ->setDescription('la petite toile numéro ' .($i +1))
                ->setAnnee(2018)
                ->setPrix(80)
                ->setDisponibilite(1);
            $manager->persist($artwork);
        }


        $manager->flush();
    }
}
