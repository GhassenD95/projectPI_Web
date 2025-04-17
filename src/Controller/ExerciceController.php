<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Form\ExerciceType;
use App\Repository\ExerciceRepository;
use App\Service\ExerciseApiService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use function PHPUnit\Framework\matchesRegularExpression;

#[Route('/exercice')]
final class ExerciceController extends AbstractController
{
    private ExerciseApiService $exerciseApiService;

    // Inject the ExerciseApiService in the constructor
    public function __construct(ExerciseApiService $exerciseApiService)
    {
        $this->exerciseApiService = $exerciseApiService;
    }

    #[Route(name: 'app_exercice_index', methods: ['GET'])]
    public function index(
        ExerciceRepository $exerciceRepository,
        PaginatorInterface $paginator,
        Request            $request
    ): Response
    {
        $search = $request->query->get('search');
        $type = $request->query->get('type');

        $qb = $exerciceRepository->createQueryBuilder('e');

        if ($search) {
            $qb->andWhere('e.nom LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($type) {
            $qb->andWhere('e.typeExercice = :type')
                ->setParameter('type', $type);
        }

        $query = $qb->getQuery();

        $exercices = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('exercice/index.html.twig', [
            'exercices' => $exercices,
            'search' => $search,
            'type' => $type,
        ]);
    }

    #[Route('/new', name: 'app_exercice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            // Handle file upload

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/images',
                        $newFilename
                    );
                    $exercice->setImageUrl('/uploads/images/' . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Failed to upload image');
                }
            }
            $entityManager->persist($exercice);
            $entityManager->flush();
            $this->addFlash('success', 'Exercise created successfully!');
            return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercice/new.html.twig', [
            'exercice' => $exercice,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/{id}', name: 'app_exercice_show', methods: ['GET'])]
    public function show(Exercice $exercice, ExerciseApiService $exerciseApiService): Response
    {
        $exerciseName = trim($exercice->getNom());
        $bestMatch = null;
        $alternatives = [];
        $percent = 0;

        try {
            $apiResults = $exerciseApiService->getAllExercises();
            if (count($apiResults) > 0) {
                foreach ($apiResults as $apiResult) {
                    similar_text($apiResult['name'], $exerciseName, $percent);
                    if ($percent >= 40) {
                        // Store just the API result (not the percent/data structure)
                        $alternatives[] = $apiResult;
                    }
                }

                // Sort by similarity (highest first)
                usort($alternatives, function ($a, $b) use ($exerciseName) {
                    similar_text($a['name'], $exerciseName, $percentA);
                    similar_text($b['name'], $exerciseName, $percentB);
                    return $percentB <=> $percentA; // Descending order
                });

                // The best match is the first alternative (if any)
                $bestMatch = !empty($alternatives) ? $alternatives[0] : null;

                // Remove the best match from alternatives (to avoid duplication)
                if ($bestMatch) {
                    array_shift($alternatives);
                }
            }
        } catch (ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            // Handle error if needed
        }

        return $this->render('exercice/show.html.twig', [
            'exercice' => $exercice,
            'bestMatch' => $bestMatch, // Direct API result (associative array)
            'alternatives' => array_slice($alternatives, 0, 5), // First 5 alternatives
        ]);
    }




    #[Route('/{id}/edit', name: 'app_exercice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercice/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercice_delete', methods: ['POST'])]
    public function delete(Request $request, Exercice $exercice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $exercice->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exercice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exercice_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/api/suggest', name: 'api_exercise_suggest', methods: ['GET'])]
    public function suggestExercises(Request $request, ExerciseApiService $apiService): JsonResponse
    {
        $query = $request->query->get('q', '');
        $limit = $request->query->getInt('limit', 5);
        $percent = 0;

        try {
            $allExercises = $apiService->getAllExercises();
            $suggestions = [];

            // Loop through all exercises and calculate similarity
            foreach ($allExercises as $exercise) {
                similar_text($exercise['name'], $query, $percent);
                // If the similarity is greater than or equal to 40%, add to suggestions
                if ($percent >= 40) {
                    $suggestions[] = $exercise['name']; // Only add the name
                }
            }

            // Sort the suggestions based on the similarity percentage (from highest to lowest)
            usort($suggestions, function ($a, $b) use ($query) {
                similar_text($a, $query, $percentA);
                similar_text($b, $query, $percentB);
                return $percentB <=> $percentA; // Descending order
            });

            // Slice to get the top 5 matches
            $suggestions = array_slice($suggestions, 0, $limit);

            return $this->json([
                'success' => true,
                'suggestions' => $suggestions
            ]);

        } catch (ClientExceptionInterface|TransportExceptionInterface|DecodingExceptionInterface $e) {
            return $this->json([
                'success' => false,
                'error' => 'Unable to fetch suggestions'
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        } catch (RedirectionExceptionInterface|ServerExceptionInterface $e) {
            return $this->json([]);
        }
    }




}
