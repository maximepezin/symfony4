<?php
// src/Controller/MaterielPieceRechangeController.php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\MaterielPieceRechange;
use App\Form\MaterielPieceRechangeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MaterielPieceRechangeController extends Controller {
    /**
     * @Route(
     *     "/materiel/{slugMateriel}/piece-rechange/ajouter",
     *     name="base_materiel_materiel_piece_rechange_ajouter",
     *     requirements={
     *         "slugMateriel": "[a-z0-9\-]+",
     *     },
     * )
     */
    public function ajouter(Request $request, string $slugMateriel) {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $materielRepository = $em->getRepository(Materiel::class);

        $materiel = $materielRepository->findOneBy([
            'slug' => $slugMateriel,
        ]);

        if ($materiel === null) {
            throw $this->createNotFoundException();
        }

        $materielPieceRechange = new MaterielPieceRechange($materiel);

        $form = $this->createForm(MaterielPieceRechangeType::class, $materielPieceRechange);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($materielPieceRechange);
            $em->flush();

            $this->addFlash('success', 'Pièce de rechange ajoutée avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('materiel_piece_rechange/ajouter.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }
}
