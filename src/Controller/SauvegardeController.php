<?php
// src/Controller/SauvegardeController.php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Sauvegarde;
use App\Form\SauvegardeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SauvegardeController extends Controller {
    /**
     * @Route(
     *     "/materiel/{slugMateriel}/sauvegarde/ajouter",
     *     name="base_materiel_sauvegarde_ajouter",
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

        $sauvegarde = new Sauvegarde($materiel);

        $form = $this->createForm(SauvegardeType::class, $sauvegarde);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($sauvegarde);
            $em->flush();

            $this->addFlash('success', 'Sauvegarde ajoutée avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('sauvegarde/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/materiel/{slugMateriel}/sauvegarde/editer/{id}",
     *     name="base_materiel_sauvegarde_editer",
     *     requirements={
     *         "slugMateriel": "[a-z0-9\-]+",
     *         "id": "\d+",
     *     },
     * )
     */
    public function editer(Request $request, string $slugMateriel, int $id) {
        // TODO: Implémenter la fonctionnalité d'édition de sauvegardes d'un matériel
        die();
    }

    /**
     * @Route(
     *     "/materiel/{slugMateriel}/sauvegarde/supprimer/{id}",
     *     name="base_materiel_sauvegarde_supprimer",
     *     requirements={
     *         "slugMateriel": "[a-z0-9\-]+",
     *         "id": "\d+",
     *     },
     * )
     */
    public function supprimer(Request $request, string $slugMateriel, int $id) {
        // TODO: Implémenter la fonctionnalité de suppression de sauvegardes d'un matériel
        die();
    }
}
