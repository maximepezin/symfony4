<?php
// src/Controller/CoreController.php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Sauvegarde;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller {
    /**
     * @Route(
     *     "/",
     *     name="base_materiel_tableau_bord",
     * )
     *
     * @return Response
     */
    public function tableauBord(): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $materielRepository = $em->getRepository(Materiel::class);
        $sauvegardeRepository = $em->getRepository(Sauvegarde::class);
        $utilisateurRepository = $em->getRepository(Utilisateur::class);

        $nbMateriels = $materielRepository->count([]);
        $nbPiecesRechange = $materielRepository->count([
            'estPieceRechange' => true,
        ]);
        $nbSauvegardes = $sauvegardeRepository->count([]);
        $nbUtilisateurs = $utilisateurRepository->count([]);

        return $this->render('core/tableau_bord.html.twig', [
            'nb_materiels' => $nbMateriels,
            'nb_pieces_rechange' => $nbPiecesRechange,
            'nb_sauvegardes' => $nbSauvegardes,
            'nb_utilisateurs' => $nbUtilisateurs,
        ]);
    }
}
