<?php
// src/Controller/LocalController.php

namespace App\Controller;

use App\Entity\Local;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocalController extends Controller {
    /**
     * @Route(
     *     "/locaux",
     *     name="base_materiel_locaux",
     * )
     */
    public function locaux() {
        $localRepository = $this
            ->getDoctrine()
            ->getRepository(Local::class)
        ;

        $locaux = $localRepository->findAll();

        return $this->render('local/locaux.html.twig', [
            'locaux' => $locaux
        ]);
    }
}
