<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    public const ADMIN_REFERENCE = 'admin';
    public const MANAGER_REFERENCE = 'manager_';
    public const COACH_REFERENCE = 'coach_';
    public const ATHLETE_REFERENCE = 'athlete_';

    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Create Admin
        $admin = new Utilisateur();
        $admin->setNom('Admin')
            ->setPrenom('System')
            ->setEmail('admin@sport.com')
            ->setPassword($this->hasher->hashPassword($admin, 'admin123'))
            ->setRole('ADMIN')
            ->setAdresse('123 Admin Street, Tunis')
            ->setTelephone('+21650123456')
            ->setStatus('ACTIVE');

        $manager->persist($admin);
        $this->addReference(self::ADMIN_REFERENCE, $admin);

        // Create 3 managers
        for ($i = 1; $i <= 3; $i++) {
            $managerUser = new Utilisateur();
            $managerUser->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setEmail("manager{$i}@sport.com")
                ->setPassword($this->hasher->hashPassword($managerUser, 'manager123'))
                ->setRole('MANAGER')
                ->setAdresse($faker->address)
                ->setTelephone('+216' . $faker->numberBetween(20, 99) . $faker->numberBetween(100000, 999999))
                ->setStatus('ACTIVE');

            $manager->persist($managerUser);
            $this->addReference(self::MANAGER_REFERENCE . $i, $managerUser);
        }


        // Create 5 coaches
        for ($i = 1; $i <= 5; $i++) {
            $coach = new Utilisateur();
            $coach->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setEmail("coach{$i}@sport.com")
                ->setPassword($this->hasher->hashPassword($coach, 'coach123'))
                ->setRole('COACH')
                ->setAdresse($faker->address)
                ->setTelephone('+216' . $faker->numberBetween(20, 99) . $faker->numberBetween(100000, 999999))
                ->setStatus('ACTIVE');

            $manager->persist($coach);
            $this->addReference(self::COACH_REFERENCE . $i, $coach);
        }

        // Create 150 athletes
        for ($i = 1; $i <= 30; $i++) {
            $athlete = new Utilisateur();
            $athlete->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setEmail("athlete{$i}@sport.com")
                ->setPassword($this->hasher->hashPassword($athlete, 'athlete123'))
                ->setRole('ATHLETE')
                ->setAdresse($faker->address)
                ->setTelephone('+216' . $faker->numberBetween(20, 99) . $faker->numberBetween(100000, 999999))
                ->setStatus('ACTIVE');

            $manager->persist($athlete);
            $this->addReference(self::ATHLETE_REFERENCE . $i, $athlete);
        }

        $manager->flush();
    }
}