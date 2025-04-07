<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EquipeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Create 30 teams
        for ($i = 1; $i <= 30; $i++) {
            $team = new Equipe();

            // Get coach reference (cycling through 5 coaches)
            $coachNumber = ($i % 5) + 1;
            $coach = $this->getReference(UtilisateurFixtures::COACH_REFERENCE . $coachNumber, Utilisateur::class);

            $team->setNom($faker->city . ' ' . $faker->randomElement(['FC', 'United', 'Athletic']))
                ->setCoach($coach)
                ->setDivision($this->getRandomDivision($i))
                ->setSport($this->getRandomSport($i))
                ->setIsLocal($i === 1);

            // Assign 5 athletes to each team (150 athletes total)
            for ($j = 1; $j <= 5; $j++) {
                $athleteNumber = (($i-1)*5) + $j;
                if ($athleteNumber <= 20) { // Only assign if we have enough athletes
                    $athlete = $this->getReference(UtilisateurFixtures::ATHLETE_REFERENCE . $athleteNumber, Utilisateur::class);
                    $team->addMembre($athlete);
                    $athlete->setEquipe($team);
                    $manager->persist($athlete);
                }
            }

            $manager->persist($team);
            $this->addReference('team_'.$i, $team);
        }

        $manager->flush();
    }

    private function getRandomDivision(int $index): string
    {
        $divisions = ['JEUNES', 'AMATEUR', 'PRO'];
        return $divisions[$index % 3];
    }

    private function getRandomSport(int $index): string
    {
        $sports = ['FOOTBALL', 'BASKETBALL', 'HANDBALL'];
        return $sports[$index % 3];
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class
        ];
    }
}