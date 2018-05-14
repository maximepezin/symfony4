<?php
// src/Controller/SupportSauvegardeController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SupportSauvegardeController extends Controller {
    /**
     * @param Request $request
     */
    public function ajouter(Request $request) {

    }

    /**
     * @Route(
     *     "/supports-sauvegarde",
     *     name="base_materiel_supports_sauvegarde",
     * )
     */
    public function supportsSauvegarde() {
        // TODO: Implémenter la fonctionnalité d'ajout de supports de sauvegarde
        die();
    }

    public function editer() {
        // TODO: Implémenter la fonctionnalité d'édition de supports de sauvegarde
        die();
    }

    public function supprimer() {
        // TODO: Implémenter la fonctionnalité de suppression de supports de sauvegarde
        die();
    }
}
