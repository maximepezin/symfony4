<?php
// src/Controller/EmplacementController.php

namespace App\Controller;

use App\Entity\Emplacement;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmplacementController extends Controller {
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
