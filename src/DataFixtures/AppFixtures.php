<?php


namespace App\DataFixtures;

use App\Entity\Agent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 25; $i++) {
            $agent = new Agent();
            $agent->setNom($faker->lastName);
            $agent->setPrenom($faker->firstName);
            $agent->setService($faker->city);
            $agent->setLienEmpl($faker->city);

            $manager->persist($agent);
        }

        $manager->flush();
    }
}
