<?php

namespace App\Repository;

use App\Entity\Exercice_entrainment;
use App\Entity\ExerciceEntrainment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ExerciceEntrainmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciceEntrainment::class);
    }

    // Add custom methods as needed
}