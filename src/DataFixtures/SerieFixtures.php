<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SerieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++) {

            $serie = new Serie();
            $serie->setName($faker->realText(25))
                ->setOverview($faker->paragraph(3))
                ->setGenre($faker->randomElement(['Drama', 'Animé', 'SF']))
                ->setStatus($faker->randomElement(['returning', 'ended', 'canceled']))
                ->setVote($faker->randomFloat(2, 0, 10))
                ->setPopularity($faker->randomFloat(2, 200, 1000))
                ->setFirstAirDate($faker->dateTimeBetween('-10 year', 'now'))
                ->setDateCreated(new \DateTime());

            if ($serie->getStatus() !== 'returning') {
                $serie->setLastAirDate($faker->dateTimeBetween('-10 year', 'now'));
            }

            $manager->persist($serie);
        }

         $manager->flush();

    }
}
