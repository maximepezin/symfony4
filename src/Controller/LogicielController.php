<?php
// src/Controller/LogicielController.php

namespace App\Controller;

use App\Entity\Logiciel;
use App\Form\LogicielType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogicielController extends Controller {
    /**
     * @Route(
     *     "/logiciel/ajouter",
     *     name="base_materiel_logiciel_ajouter",
     * )
     */
    public function ajouter(Request $request) {
        $logiciel = new Logiciel();

        $form = $this->createForm(LogicielType::class, $logiciel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($logiciel);
            $em->flush();

            $this->addFlash('success', 'Logiciel créé avec succès.');

            return $this->redirectToRoute('base_materiel_logiciels');
        }

        return $this->render('logiciel/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/logiciels",
     *     name="base_materiel_logiciels",
     * )
     */
    public function logiciels() {
        $logicielRepository = $this
            ->getDoctrine()
            ->getRepository(Logiciel::class)
        ;

        $logiciels = $logicielRepository->findAll();

        return $this->render('logiciel/logiciels.html.twig', [
            'logiciels' => $logiciels,
        ]);
    }

    /**
     * @Route(
     *     "/logiciel/editer/{id}",
     *     name="base_materiel_logiciel_editer",
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

        $logicielRepository = $em->getRepository(Logiciel::class);

        $logiciel = $logicielRepository->find($id);

        if ($logiciel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(LogicielType::class, $logiciel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Logiciel modifié avec succès.');

            return $this->redirectToRoute('base_materiel_logiciels');
        }

        return $this->render('logiciel/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/logiciel/supprimer/{id}",
     *     name="base_materiel_logiciel_supprimer",
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

        $logicielRepository = $em->getRepository(Logiciel::class);

        $logiciel = $logicielRepository->find($id);

        if ($logiciel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($logiciel);
            $em->flush();

            $this->addFlash('success', 'Logiciel supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_logiciels');
        }

        return $this->render('logiciel/supprimer.html.twig', [
            'logiciel' => $logiciel,
            'form' => $form->createView(),
        ]);
    }
}
