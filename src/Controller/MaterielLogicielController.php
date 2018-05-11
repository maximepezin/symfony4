<?php
// src/Controller/MaterielLogicielController.php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\MaterielLogiciel;
use App\Form\MaterielLogicielType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MaterielLogicielController extends Controller {
    /**
     * @Route(
     *     "/materiel/{slugMateriel}/logiciel/ajouter",
     *     name="base_materiel_materiel_logiciel_ajouter",
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

        $materielLogiciel = new MaterielLogiciel($materiel);

        $form = $this->createForm(MaterielLogicielType::class, $materielLogiciel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($materielLogiciel);
            $em->flush();

            $this->addFlash('success', 'Logiciel ajouté avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('materiel_logiciel/ajouter.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/materiel/{slugMateriel}/logiciel/editer/{id}",
     *     name="base_materiel_materiel_logiciel_editer",
     *     requirements={
     *         "slugMateriel": "[a-z0-9\-]+",
     *         "id": "\d+",
     *     },
     * )
     */
    public function editer(Request $request, string $slugMateriel, int $id) {
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

        $materielLogicielRepository = $em->getRepository(MaterielLogiciel::class);

        $materielLogiciel = $materielLogicielRepository->findOneBy([
            'id' => $id,
            'materiel' => $materiel,
        ]);

        if ($materielLogiciel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(MaterielLogicielType::class, $materielLogiciel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($materielLogiciel);
            $em->flush();

            $this->addFlash('success', 'Logiciel modifié avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('materiel_logiciel/editer.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/materiel/{slugMateriel}/logiciel/supprimer/{id}",
     *     name="base_materiel_materiel_logiciel_supprimer",
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

        $materielLogicielRepository = $em->getRepository(MaterielLogiciel::class);

        $materielLogiciel = $materielLogicielRepository->findOneBy([
            'id' => $id,
            'materiel' => $materiel,
        ]);

        if ($materielLogiciel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($materielLogiciel);
            $em->flush();

            $this->addFlash('success', 'Logiciel supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('materiel_logiciel/supprimer.html.twig', [
            'materiel' => $materiel,
            'materiel_logiciel' => $materielLogiciel,
            'form' => $form->createView(),
        ]);
    }
}
