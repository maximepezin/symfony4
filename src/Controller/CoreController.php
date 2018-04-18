<?php
// src/Controller/CoreController.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller {
    /**
     * @Route(
     *     "/",
     *     name="base_materiel_tableau_bord",
     * )
     */
    public function tableauBord() {
        return $this->render('core/tableau_bord.html.twig', [
            null,
        ]);
    }
}
