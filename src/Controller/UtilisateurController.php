<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur',name: 'app_utilisateur_index', methods: ['GET'])]
    #[Route('/admin/utilisateur', name: 'app_admin_utilisateur', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {

        if ($this->isGranted('ROLE_ADMIN')) {
            $utilisateurs = $utilisateurRepository->findAll();
        } else {
            $utilisateurs = $utilisateurRepository->findCoachesAndAthletes();
        }

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    #[Route('/utilisateur/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    #[Route('/admin/utilisateur/new', name: 'app_admin_utilisateur-new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur, [
            'require_password' => true
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload


            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/images',
                        $newFilename
                    );
                    $utilisateur->setImageUrl('/uploads/images/'.$newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Failed to upload image');
                }
            }

            // Hash password
            $utilisateur->setPassword(
                password_hash($utilisateur->getPassword(), PASSWORD_DEFAULT)
            );

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }
    #[Route('/utilisateur/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    #[Route('/admin/utilisateur/{id}', name: 'app_admin_utilisateur-show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/utilisateur/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    #[Route('/admin/utilisateur/{id}/edit', name: 'app_admin_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $originalPassword = $utilisateur->getPassword();
        $originalImageUrl = $utilisateur->getImageUrl();

        $form = $this->createForm(UtilisateurType::class, $utilisateur, [
            'require_password' => false
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('imageUrl')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/images',
                        $newFilename
                    );
                    // Delete old image if it exists
                    if ($originalImageUrl && file_exists($this->getParameter('kernel.project_dir').'/public'.$originalImageUrl)) {
                        unlink($this->getParameter('kernel.project_dir').'/public'.$originalImageUrl);
                    }
                    $utilisateur->setImageUrl('/uploads/images/'.$newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Failed to upload image');
                }
            }

            // Only update password if provided
            $newPassword = $form->get('password')->getData();
            if ($newPassword) {
                $utilisateur->setPassword(
                    password_hash($newPassword, PASSWORD_DEFAULT)
                );
            } else {
                $utilisateur->setPassword($originalPassword);
            }

            $entityManager->flush();
            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }
    #[Route('/utilisateur/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    #[Route('/admin/utilisateur/{id}', name: 'app_admin_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
