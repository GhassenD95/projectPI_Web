<?php

namespace App\Controller;

use App\Entity\Entrainment;
use App\Entity\Exercice;
use App\Entity\ExerciceEntrainment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExerciceEntrainmentController extends AbstractController
{
    #[Route('/entrainment/{entrainment_id}/exercice/new', name: 'app_exercice_entrainment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $entrainment_id): Response
    {
        $entrainment = $entityManager->getRepository(Entrainment::class)->find($entrainment_id);
        if (!$entrainment) {
            throw $this->createNotFoundException('Training session not found');
        }

        if ($request->isMethod('POST')) {
            $exerciceId = $request->request->get('exercice');

            $exercice = $entityManager->getRepository(Exercice::class)->find($exerciceId);
            if (!$exercice) {
                throw $this->createNotFoundException('Exercise not found');
            }

            $exerciceEntrainment = new ExerciceEntrainment();
            $exerciceEntrainment->setEntrainment($entrainment);
            $exerciceEntrainment->setExercice($exercice);

            $entityManager->persist($exerciceEntrainment);
            $entityManager->flush();

            return $this->redirectToRoute('app_entrainment_show', ['id' => $entrainment_id]);
        }

        return $this->redirectToRoute('app_entrainment_show', ['id' => $entrainment_id]);
    }

    #[Route('/exercice_entrainment/{id}/delete', name: 'app_exercice_entrainment_delete', methods: ['POST'])]
    public function delete(Request $request, ExerciceEntrainment $exerciceEntrainment, EntityManagerInterface $entityManager): Response
    {
        $entrainmentId = $exerciceEntrainment->getEntrainment()->getId();

        if ($this->isCsrfTokenValid('delete'.$exerciceEntrainment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($exerciceEntrainment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_entrainment_show', ['id' => $entrainmentId]);
    }
}
