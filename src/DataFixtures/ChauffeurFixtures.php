<?php


namespace App\DataFixtures;

use App\Entity\Chauffeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ChauffeurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 25; $i++) {
            $chauffeur = new Chauffeur();
            $chauffeur->setNom($faker->lastName);
            $chauffeur->setPrenom($faker->firstName);
            $chauffeur->setNumero($faker->numberBetween(90000001, 95999999));
            $chauffeur->setAdress($faker->city);

            $manager->persist($chauffeur);
        }

        $manager->flush();
    }
}
