<?php

namespace App\Repository;

use App\Entity\Exercice_entrainment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class Exercice_entrainmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercice_entrainment::class);
    }

    // Add custom methods as needed
}