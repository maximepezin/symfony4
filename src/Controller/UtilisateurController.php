<?php
// src/Controller/UtilisateurController.php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Classe UtilisateurController
 *
 * @package App\Controller
 */
class UtilisateurController extends Controller {
    /**
     * @Route(
     *     "/utilisateurs",
     *     name="base_materiel_utilisateurs"
     * )
     *
     * @return Response
     */
    public function utilisateurs(): Response {
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
