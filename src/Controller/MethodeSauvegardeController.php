<?php
// src/Controller/MethodeSauvegardeController.php

namespace App\Controller;

use App\Entity\MethodeSauvegarde;
use App\Form\MethodeSauvegardeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MethodeSauvegardeController extends Controller {
    /**
     * @Route(
     *     "/methode-sauvegarde/ajouter",
     *     name="base_materiel_methode_sauvegarde_ajouter",
     * )
     */
    public function ajouter(Request $request) {
        $methodeSauvegarde = new MethodeSauvegarde();

        $form = $this->createForm(MethodeSauvegardeType::class, $methodeSauvegarde);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($methodeSauvegarde);
            $em->flush();

            $this->addFlash('success', 'Méthode de sauvegarde ajoutée avec succès.');

            return $this->redirectToRoute('base_materiel_methodes_sauvegarde');
        }

        return $this->render('methode_sauvegarde/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/methodes-sauvegarde",
     *     name="base_materiel_methodes_sauvegarde",
     * )
     */
    public function methodesSauvegarde() {
        $methodeSauvegardeRepository = $this
            ->getDoctrine()
            ->getRepository(MethodeSauvegarde::class)
        ;

        $methodesSauvegarde = $methodeSauvegardeRepository->findAll();

        return $this->render('methode_sauvegarde/methodes_sauvegarde.html.twig', [
            'methodes_sauvegarde' => $methodesSauvegarde,
        ]);
    }

    /**
     * @Route(
     *     "/methode-sauvegarde/editer/{id}",
     *     name="base_materiel_methode_sauvegarde_editer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     */
    public function editer(Request $request, int $id) {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $methodeSauvegardeRepository = $em->getRepository(MethodeSauvegarde::class);

        $methodeSauvegarde = $methodeSauvegardeRepository->find($id);

        if ($methodeSauvegarde === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(MethodeSauvegardeType::class, $methodeSauvegarde);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Méthode de sauvegarde modifiée avec succès.');

            return $this->redirectToRoute('base_materiel_methodes_sauvegarde');
        }

        return $this->render('methode_sauvegarde/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/methode-sauvegarde/supprimer/{id}",
     *     name="base_materiel_methode_sauvegarde_supprimer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     */
    public function supprimer(Request $request, int $id) {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $methodeSauvegardeRepository = $em->getRepository(MethodeSauvegarde::class);

        $methodeSauvegarde = $methodeSauvegardeRepository->find($id);

        if ($methodeSauvegarde === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($methodeSauvegarde);
            $em->flush();

            $this->addFlash('success', 'Méthode de sauvegarde supprimée avec succès.');

            return $this->redirectToRoute('base_materiel_methodes_sauvegarde');
        }

        return $this->render('methode_sauvegarde/supprimer.html.twig', [
            'methode_sauvegarde' => $methodeSauvegarde,
            'form' => $form->createView(),
        ]);
    }
}
