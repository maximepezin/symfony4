<?php
// src/Controller/EmplacementController.php

namespace App\Controller;

use App\Entity\Emplacement;
use App\Form\EmplacementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmplacementController extends Controller {
    /**
     * @Route(
     *     "/emplacement/ajouter",
     *     name="base_materiel_emplacement_ajouter",
     * )
     */
    public function ajouter(Request $request) {
        $emplacement = new Emplacement();

        $form = $this->createForm(EmplacementType::class, $emplacement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($emplacement);
            $em->flush();

            $this->addFlash('success', 'Emplacement ajouté avec succès.');

            return $this->redirectToRoute('base_materiel_emplacements');
        }

        return $this->render('emplacement/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/emplacements",
     *    name="base_materiel_emplacements",
     * )
     */
    public function emplacements() {
        $emplacementRepository = $this
            ->getDoctrine()
            ->getRepository(Emplacement::class)
        ;

        $emplacements = $emplacementRepository->findAll();

        return $this->render('emplacement/emplacements.html.twig', [
            'emplacements' => $emplacements,
        ]);
    }
}
