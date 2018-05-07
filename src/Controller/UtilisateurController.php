<?php
// src/Controller/UtilisateurController.php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UtilisateurController extends Controller {
    /**
     * @Route(
     *     "/utilisateurs",
     *     name="base_materiel_utilisateurs"
     * )
     */
    public function utilisateurs() {
        $utilisateurRepository = $this
            ->getDoctrine()
            ->getRepository(Utilisateur::class)
        ;

        $utilisateurs = $utilisateurRepository->findAll();

        return $this->render('utilisateur/utilisateurs.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }
}
