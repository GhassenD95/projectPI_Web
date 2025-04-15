<?php

namespace App\Controller;

use App\Entity\Entrainment;
use App\Entity\Equipe;
use App\Entity\Equipement;
use App\Entity\Tournois;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        //get all users
        $totalUsers = $entityManager->getRepository(Utilisateur::class)->count();
        $totalTrainingSession = $entityManager->getRepository(Entrainment::class)->count();
        $totalEquipements = $entityManager->getRepository(Equipement::class)->count();
        $totalTeams = $entityManager->getRepository(Equipe::class)->count();
        $totalAthletes = count(array_filter($entityManager->getRepository(Utilisateur::class)->findAll(), function ($item) {
            return $item->getRoles() == ['ROLE_ATHLETE'];
        }));
        $totalCoaches = count(array_filter($entityManager->getRepository(Utilisateur::class)->findAll(), function ($item) {
            return $item->getRoles() == ['ROLE_COACH'];
        }));
        $totalManagers = count(array_filter($entityManager->getRepository(Utilisateur::class)->findAll(), function ($item) {
            return $item->getRoles() == ['ROLE_MANAGER'];
        }));

        return $this->render('admin/index.html.twig', [
            'equipements' => $totalEquipements,
            'users' => $totalUsers,
            'trainings' => $totalTrainingSession,
            'teams' => $totalTeams,
            'athletePercentage' => $totalAthletes * 100 / $totalUsers,
            'coachPercentage' => $totalCoaches * 100 / $totalUsers,
            'managerPercentage' => $totalManagers * 100 / $totalUsers,
        ]);
    }




}
