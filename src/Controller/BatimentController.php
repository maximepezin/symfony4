<?php
// src/Controller/BatimentController.php

namespace App\Controller;

use App\Entity\Batiment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BatimentController extends Controller {
    /**
     * @Route(
     *     "/batiments",
     *     name="base_materiel_batiments",
     * )
     */
    public function batiments() {
        $batimentRepository = $this
            ->getDoctrine()
            ->getRepository(Batiment::class)
        ;

        $batiments = $batimentRepository->findAll();

        return $this->render('batiment/batiments.html.twig', [
            'batiments' => $batiments,
        ]);
    }
}
