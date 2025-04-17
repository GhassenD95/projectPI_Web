<?php

namespace App\Repository;

use App\Entity\Entrainment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EntrainmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrainment::class);
    }
/*
    public function findAllCoaches(): array
    {
        return $this->createQueryBuilder('e')
            ->select('DISTINCT eq.nom') // Assuming 'nom' is the coach's name in Equipe
            ->join('e.equipe', 'eq')
            ->orderBy('eq.nom', 'ASC')
            ->getQuery()
            ->getScalarResult();
    }

    public function findAllLocations(): array
    {
        return $this->createQueryBuilder('e')
            ->select('DISTINCT i.id, i.nom')
            ->join('e.installationSportive', 'i')
            ->orderBy('i.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllTeams(): array
    {
        return $this->createQueryBuilder('e')
            ->select('DISTINCT t.id, t.nom')
            ->join('e.equipe', 't')
            ->orderBy('t.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }*/
}