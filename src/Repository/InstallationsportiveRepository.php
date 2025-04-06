<?php

namespace App\Repository;

use App\Entity\Installationsportive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class InstallationsportiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Installationsportive::class);
    }

    // Add custom methods as needed
}