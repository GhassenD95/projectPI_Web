<?php

namespace App\Controller;

use App\Entity\Entrainment;
use App\Entity\Equipe;
use App\Entity\Equipement;
use App\Entity\Tournois;
use App\Entity\Utilisateur;
use App\Service\UserActionLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    private UserActionLogger $userActionLogger;

    public function __construct(UserActionLogger $userActionLogger)
    {
        $this->userActionLogger = $userActionLogger;
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Log admin dashboard access
        $this->userActionLogger->log('Accessed Admin Dashboard', 'Admin Panel');

        // Get all users
        $totalUsers = $entityManager->getRepository(Utilisateur::class)->count();
        $totalTrainingSession = $entityManager->getRepository(Entrainment::class)->count();
        $totalEquipements = $entityManager->getRepository(Equipement::class)->count();
        $totalTeams = $entityManager->getRepository(Equipe::class)->count();
        $totalAthletes = count(array_filter($entityManager->getRepository(Utilisateur::class)->findAll(), function ($item) {
            return in_array('ROLE_ATHLETE', $item->getRoles());
        }));
        $totalCoaches = count(array_filter($entityManager->getRepository(Utilisateur::class)->findAll(), function ($item) {
            return in_array('ROLE_COACH', $item->getRoles());
        }));
        $totalManagers = count(array_filter($entityManager->getRepository(Utilisateur::class)->findAll(), function ($item) {
            return in_array('ROLE_MANAGER', $item->getRoles());
        }));

        $logDirectory = $this->getParameter('kernel.logs_dir');
        $logFilename = 'user_actions-' . date('Y-m-d') . '.log';
        $logFilePath = $logDirectory . '/' . $logFilename;
        $logs = [];

        if (file_exists($logFilePath)) {
            $logLines = file($logFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach (array_reverse($logLines) as $line) { // Read in reverse to get latest first
                if (preg_match('/^\[(.*?)\] (.*?) User Action: (.*?) - User: (.*?)(?: - Context: (.*?))?(?: - Details: (.*?))? (\{.*\})? (\[\])?$/', $line, $matches)) {
                    $logs[] = [
                        'timestamp' => new \DateTimeImmutable($matches[1]),
                        'level' => trim(explode('.', $matches[2])[1] ?? $matches[2]), // Extract level after the channel
                        'action_type' => trim($matches[3]),
                        'user' => trim($matches[4]),
                        'context' => trim($matches[5]) ?: null,
                        'details' => isset($matches[6]) && trim($matches[6]) ? json_decode(trim($matches[6]), true) : null,
                    ];
                    if (count($logs) >= 5) {
                        break; // Stop after reading 5 latest logs
                    }
                }
            }
        }

        return $this->render('admin/index.html.twig', [
            'recent_activity_logs' => $logs,
            'equipements' => $totalEquipements,
            'users' => $totalUsers,
            'trainings' => $totalTrainingSession,
            'teams' => $totalTeams,
            'athletePercentage' => $totalAthletes > 0 && $totalUsers > 0 ? ($totalAthletes * 100 / $totalUsers) : 0,
            'coachPercentage' => $totalCoaches > 0 && $totalUsers > 0 ? ($totalCoaches * 100 / $totalUsers) : 0,
            'managerPercentage' => $totalManagers > 0 && $totalUsers > 0 ? ($totalManagers * 100 / $totalUsers) : 0,
        ]);
    }
}