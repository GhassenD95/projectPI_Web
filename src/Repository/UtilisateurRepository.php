<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    // Add custom methods as needed
    public function findCoachesAndAthletes(): array
    {
        return $this->createQueryBuilder('u')
            ->where('u.role IN (:roles)')
            ->setParameter('roles', ['COACH', 'ATHLETE'])
            ->getQuery()
            ->getResult();
    }

}