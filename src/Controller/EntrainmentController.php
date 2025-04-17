<?php

namespace App\Controller;

use App\Entity\Entrainment;
use App\Form\EntrainmentType;
use App\Repository\EntrainmentRepository;
use App\Repository\ExerciceRepository;
use App\Service\UserActionLogger;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/entrainment')]
final class EntrainmentController extends AbstractController
{
    private UserActionLogger $userActionLogger;

    public function __construct(UserActionLogger $userActionLogger)
    {
        $this->userActionLogger = $userActionLogger;
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[Route(name: 'app_entrainment_index', methods: ['GET'])]
    public function index(
        EntrainmentRepository $entrainmentRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        // Get filter parameters from request
        $filters = [
            'coach' => $request->query->get('coach'),
            'location' => $request->query->get('location'),
            'team' => $request->query->get('team'),
            'date_from' => $request->query->get('date_from'),
            'date_to' => $request->query->get('date_to'),
        ];

        // Build the query with filters
        $queryBuilder = $entrainmentRepository->createQueryBuilder('e')
            ->orderBy('e.dateDebut', 'DESC');

        // Apply filters
        if ($filters['coach']) {
            $queryBuilder->andWhere('e.coach = :coach')
                ->setParameter('coach', $filters['coach']);
        }

        if ($filters['location']) {
            $queryBuilder->andWhere('e.installationSportive = :location')
                ->setParameter('location', $filters['location']);
        }

        if ($filters['team']) {
            $queryBuilder->andWhere('e.equipe = :team')
                ->setParameter('team', $filters['team']);
        }

        if ($filters['date_from']) {
            $queryBuilder->andWhere('e.dateDebut >= :date_from')
                ->setParameter('date_from', new \DateTime($filters['date_from']));
        }

        if ($filters['date_to']) {
            $queryBuilder->andWhere('e.dateDebut <= :date_to')
                ->setParameter('date_to', new \DateTime($filters['date_to']));
        }

        $query = $queryBuilder->getQuery();

        $entrainments = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );

        // Get filter options for the form
        //$coaches = $entrainmentRepository->findAllCoaches();
        //$locations = $entrainmentRepository->findAllLocations();
        //$teams = $entrainmentRepository->findAllTeams();

        return $this->render('entrainment/index.html.twig', [
            'entrainments' => $entrainments,
            'filters' => $filters,

        ]);
    }
    #[Route('/new', name: 'app_entrainment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entrainment = new Entrainment();
        $form = $this->createForm(EntrainmentType::class, $entrainment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entrainment);
            $entityManager->flush();
            $this->userActionLogger->log('Added Entrainment', 'Entrainment', $entrainment->toArray());
            return $this->redirectToRoute('app_entrainment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entrainment/new.html.twig', [
            'entrainment' => $entrainment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entrainment_show', methods: ['GET'])]
    public function show(Entrainment $entrainment, ExerciceRepository $exerciceRepository): Response
    {
        $allExercices = $exerciceRepository->findAll();
        $assignedExerciceIds = [];

        foreach ($entrainment->getExerciceEntrainments() as $ee) {
            $assignedExerciceIds[] = $ee->getExercice()->getId();
        }

        $availableExercices = array_filter($allExercices, function($exercice) use ($assignedExerciceIds) {
            return !in_array($exercice->getId(), $assignedExerciceIds);
        });

        return $this->render('entrainment/show.html.twig', [
            'entrainment' => $entrainment,
            'availableExercices' => $availableExercices,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entrainment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entrainment $entrainment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EntrainmentType::class, $entrainment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_entrainment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entrainment/edit.html.twig', [
            'entrainment' => $entrainment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entrainment_delete', methods: ['POST'])]
    public function delete(Request $request, Entrainment $entrainment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrainment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($entrainment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_entrainment_index', [], Response::HTTP_SEE_OTHER);
    }
}
