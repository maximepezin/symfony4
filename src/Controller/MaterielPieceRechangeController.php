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
        $materielRepository = $this
            ->getDoctrine()
            ->getRepository(Materiel::class)
        ;

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
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

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

    /**
     * @Route(
     *     "/materiel/{slugMateriel}/piece-rechange/supprimer/{id}",
     *     name="base_materiel_materiel_piece_rechange_supprimer",
     *     requirements={
     *         "slugMateriel": "[a-z0-9\-]+",
     *         "id": "\d+",
     *     },
     * )
     */
    public function supprimer(Request $request, string $slugMateriel, int $id) {
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

        $materielPieceRechangeRepository = $em->getRepository(MaterielPieceRechange::class);

        $materielPieceRechange = $materielPieceRechangeRepository->findOneBy([
            'id' => $id,
            'materiel' => $materiel,
        ]);

        if ($materielPieceRechange === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($materielPieceRechange);
            $em->flush();

            $this->addFlash('success', 'Pièce de rechange supprimée avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('materiel_piece_rechange/supprimer.html.twig', [
            'materiel' => $materiel,
            'materiel_piece_rechange' => $materielPieceRechange,
            'form' => $form->createView(),
        ]);
    }
}
