<?php
// src/Controller/ModeleController.php

namespace App\Controller;

use App\Entity\Modele;
use App\Form\ModeleType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModeleController extends Controller {
    /**
     * @Route(
     *     "/modele/ajouter",
     *     name="base_materiel_modele_ajouter",
     * )
     */
    public function ajouter(Request $request) {
        $modele = new Modele();

        $form = $this->createForm(ModeleType::class, $modele);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($modele);
            $em->flush();

            $this->addFlash('success', 'Modèle créé avec succès.');

            return $this->redirectToRoute('base_materiel_modeles');
        }

        return $this->render('modele/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/modeles",
     *     name="base_materiel_modeles",
     * )
     */
    public function modeles() {
        $modeleRepository = $this
            ->getDoctrine()
            ->getRepository(Modele::class)
        ;

        $modeles = $modeleRepository->findAll();

        return $this->render('modele/modeles.html.twig', [
            'modeles' => $modeles,
        ]);
    }

    /**
     * @Route(
     *     "/modele/editer/{id}",
     *     name="base_materiel_modele_editer",
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

        $modeleRepository = $em->getRepository(Modele::class);

        $modele = $modeleRepository->find($id);

        if ($modele === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ModeleType::class, $modele);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Modèle modifié avec succès.');

            return $this->redirectToRoute('base_materiel_modeles');
        }

        return $this->render('modele/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/modele/supprimer/{id}",
     *     name="base_materiel_modele_supprimer",
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

        $modeleRepository = $em->getRepository(Modele::class);

        $modele = $modeleRepository->find($id);

        if ($modele === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->remove($modele);
                $em->flush();
            } catch (ForeignKeyConstraintViolationException $constraintViolationException) {
                $this->addFlash('warning', 'Ce modèle est utilisé et ne peut être supprimé.');

                return $this->redirectToRoute('base_materiel_modeles');
            }

            $this->addFlash('success', 'Modèle supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_modeles');
        }

        return $this->render('modele/supprimer.html.twig', [
            'modele' => $modele,
            'form' => $form->createView(),
        ]);
    }
}
