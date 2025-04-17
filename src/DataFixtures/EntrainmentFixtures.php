<?php

namespace App\DataFixtures;

use App\Entity\Entrainment;
use App\Entity\Equipe;
use App\Entity\Installationsportive;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EntrainmentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 30; $i++) {
            /** @var Equipe $team */
            $team = $this->getReference('team_' . $i, Equipe::class); // <--- Ensure Equipe::class is here

            // Cycle through installations (10 available)
            $installationNumber = ($i % 10) + 1;
            /** @var Installationsportive $installationSportive */
            $installationSportive = $this->getReference(
                InstallationsportiveFixtures::INSTALLATION_REFERENCE . $installationNumber,
                Installationsportive::class // <--- Ensure Installationsportive::class is here
            );

            // Create 2-3 training sessions per team
            $trainingCount = $faker->numberBetween(2, 3);
            for ($j = 0; $j < $trainingCount; $j++) {
                $entrainment = new Entrainment();
                $entrainment->setNom($faker->words(3, true));
                $entrainment->setDescription($faker->text(200));

                // Set start date (within next 30 days)
                $dateDebut = $faker->dateTimeBetween('now', '+30 days');
                $entrainment->setDateDebut($dateDebut);

                // Set end date (1-3 hours after start)
                $dateFin = clone $dateDebut;
                $dateFin->modify('+'.$faker->numberBetween(1, 3).' hours');
                $entrainment->setDateFin($dateFin);

                // Associate with team and installation
                $entrainment->setEquipe($team);
                $entrainment->setInstallationsportive($installationSportive);

                $manager->persist($entrainment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
            InstallationsportiveFixtures::class,
            EquipeFixtures::class,
        ];
    }
}