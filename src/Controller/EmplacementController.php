<?php
// src/Controller/EmplacementController.php

namespace App\Controller;

use App\Entity\Emplacement;
use App\Form\EmplacementType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Classe EmplacementController
 *
 * @package App\Controller
 */
class EmplacementController extends Controller {
    /**
     * @Route(
     *     "/emplacement/ajouter",
     *     name="base_materiel_emplacement_ajouter",
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(Request $request): Response {
        $emplacement = new Emplacement();

        $form = $this->createForm(EmplacementType::class, $emplacement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($emplacement);
            $em->flush();

            $this->addFlash('success', 'Emplacement ajouté avec succès.');

            return $this->redirectToRoute('base_materiel_emplacements');
        }

        return $this->render('emplacement/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/emplacements",
     *    name="base_materiel_emplacements",
     * )
     *
     * @return Response
     */
    public function emplacements(): Response {
        $emplacementRepository = $this
            ->getDoctrine()
            ->getRepository(Emplacement::class)
        ;

        $emplacements = $emplacementRepository->getEmplacements();

        return $this->render('emplacement/emplacements.html.twig', [
            'emplacements' => $emplacements,
        ]);
    }

    /**
     * @Route(
     *     "/emplacement/editer/{id}",
     *     name="base_materiel_emplacement_editer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant de l'emplacement à éditer
     *
     * @return RedirectResponse|Response
     */
    public function editer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $emplacementRepository = $em->getRepository(Emplacement::class);

        $emplacement = $emplacementRepository->find($id);

        if ($emplacement === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(EmplacementType::class, $emplacement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Emplacement modifié avec succès.');

            return $this->redirectToRoute('base_materiel_emplacements');
        }

        return $this->render('emplacement/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/emplacement/supprimer/{id}",
     *     name="base_materiel_emplacement_supprimer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant de l'emplacement à supprimer
     *
     * @return RedirectResponse|Response
     */
    public function supprimer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $emplacementRepository = $em->getRepository(Emplacement::class);

        $emplacement = $emplacementRepository->find($id);

        if ($emplacement === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($emplacement);
            $em->flush();

            $this->addFlash('success', 'Emplacement supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_emplacements');
        }

        return $this->render('emplacement/supprimer.html.twig', [
            'emplacement' => $emplacement,
            'form' => $form->createView(),
        ]);
    }
}
