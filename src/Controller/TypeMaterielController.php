<?php
// src/Controller/TypeMaterielController.php

namespace App\Controller;

use App\Entity\TypeMateriel;
use App\Form\TypeMaterielType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TypeMaterielController extends Controller {
    /**
     * @Route(
     *     "/type-materiel/ajouter",
     *     name="base_materiel_type_materiel_ajouter",
     * )
     */
    public function ajouter(Request $request) {
        $typeMateriel = new TypeMateriel();

        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($typeMateriel);
            $em->flush();

            $this->addFlash('success', 'Type de matériel créé avec succès.');

            return $this->redirectToRoute('base_materiel_types_materiel');
        }

        return $this->render('type_materiel/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/types-materiels",
     *     name="base_materiel_types_materiel",
     * )
     */
    public function typesMateriel() {
        $typeMaterielRepository = $this
            ->getDoctrine()
            ->getRepository(TypeMateriel::class)
        ;

        $typesMateriel = $typeMaterielRepository->findAll();

        return $this->render('type_materiel/types_materiel.html.twig', [
            'typesMateriel' => $typesMateriel,
        ]);
    }

    /**
     * @Route(
     *     "/type-materiel/editer/{id}",
     *     name="base_materiel_type_materiel_editer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     */
    public function editer(Request $request, int $id) {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $typeMaterielRepository = $em->getRepository(TypeMateriel::class);

        $typeMateriel = $typeMaterielRepository->find($id);

        if ($typeMateriel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Type de matériel modifié avec succès.');

            return $this->redirectToRoute('base_materiel_types_materiel');
        }

        return $this->render('type_materiel/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/type-materiel/supprimer/{id}",
     *     name="base_materiel_type_materiel_supprimer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     */
    public function supprimer(Request $request, int $id) {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $typeMaterielRepository = $em->getRepository(TypeMateriel::class);

        $typeMateriel = $typeMaterielRepository->find($id);

        if ($typeMateriel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($typeMateriel);
            $em->flush();

            $this->addFlash('success', 'Type de matériel supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_types_materiel');
        }

        return $this->render('type_materiel/supprimer.html.twig', [
            'typeMateriel' => $typeMateriel,
            'form' => $form->createView(),
        ]);
    }
}
