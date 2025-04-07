<?php

namespace App\DataFixtures;

use App\Entity\Installationsportive;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class InstallationsportiveFixtures extends Fixture implements DependentFixtureInterface
{
    public const INSTALLATION_REFERENCE = 'installation_';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $types = ['STADE', 'SALLE_GYM', 'TERRAIN', 'PISCINE'];
        $cities = ['Tunis', 'Sfax', 'Sousse', 'Bizerte', 'Gabès'];

        for ($i = 1; $i <= 10; $i++) {
            $installation = new Installationsportive();

            // Get random manager (1-3)
            $managerRefNumber = $faker->numberBetween(1, 3);
            $managerUser = $this->getReference(
                UtilisateurFixtures::MANAGER_REFERENCE . $managerRefNumber,
                Utilisateur::class
            );

            $installation
                ->setId($i)
                ->setManager($managerUser) // Changed from setManager_id() to setManager()
                ->setNom('Complexe Sportif ' . $faker->randomElement($cities))
                ->setTypeInstallation($faker->randomElement($types))
                ->setAdresse($faker->streetAddress . ', ' . $faker->city)
                ->setCapacite($this->getCapacityForType($installation->getTypeInstallation()))
                ->setIsDisponible($faker->boolean(80))
                ->setImageUrl($this->getImageForType($installation->getTypeInstallation()));

            $manager->persist($installation);
            $this->addReference(self::INSTALLATION_REFERENCE . $i, $installation);
        }

        $manager->flush();
    }

    /**
     * Fetches the highest existing ID to avoid conflicts.
     */
    private function getLastInstallationId(ObjectManager $manager): int
    {
        $repository = $manager->getRepository(Installationsportive::class);
        $lastInstallation = $repository->findOneBy([], ['id' => 'DESC']);

        return $lastInstallation ? $lastInstallation->getId() : 0;
    }

    private function getCapacityForType(string $type): int
    {
        return match($type) {
            'STADE' => 200,
            'SALLE_GYM' => 100,
            'TERRAIN' => 40,
            'PISCINE' => 50,
            default => 0
        };
    }

    private function getImageForType(string $type): string
    {
        return match($type) {
            'STADE' => 'https://example.com/stade.jpg',
            'SALLE_GYM' => 'https://example.com/gym.jpg',
            'TERRAIN' => 'https://example.com/terrain.jpg',
            'PISCINE' => 'https://example.com/piscine.jpg',
            default => 'https://example.com/default.jpg'
        };
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class
        ];
    }
}