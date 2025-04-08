<?php

namespace App\DataFixtures;

use App\Entity\Exercice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ExerciceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $types = ['MUSCULATION', 'CARDIO', 'YOGA', 'PILATES', 'NATATION', 'HIIT', 'ZUMBA'];

        for($i = 0; $i < 20; $i++) {
            $exercice = new Exercice();
            $exercice->setNom($faker->word);
            $exercice->setReps(rand(1, 10));
            $exercice->setImageUrl($faker->imageUrl());
            $exercice->setSets($faker->numberBetween(1, 10));
            $exercice->setDureeMinutes($faker->numberBetween(1, 20));
            $exercice->setTypeExercice($types[array_rand($types)]);
            $manager->persist($exercice);
        }


        $manager->flush();
    }
}
