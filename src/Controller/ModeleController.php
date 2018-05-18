<?php
// src/Controller/ModeleController.php

namespace App\Controller;

use App\Entity\Modele;
use App\Form\ModeleType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Classe ModeleController
 *
 * @package App\Controller
 */
class ModeleController extends Controller {
    /**
     * @Route(
     *     "/modele/ajouter",
     *     name="base_materiel_modele_ajouter",
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(Request $request): Response {
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

            $this->addFlash('success', 'Modèle ajouté avec succès.');

            return $this->redirectToRoute('base_materiel_modeles');
        }

        return $this->render('modele/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/modeles/{numPage}",
     *     name="base_materiel_modeles",
     *     requirements={
     *         "numPage": "\d+",
     *     },
     *     defaults={
     *         "numPage": 1,
     *     },
     * )
     *
     * @param int $numPage Le numéro de la page à afficher
     *
     * @return Response
     */
    public function modeles(int $numPage = 1): Response {
        $modeleRepository = $this
            ->getDoctrine()
            ->getRepository(Modele::class)
        ;

        $modeles = $modeleRepository->getPaginationModeles(
            $numPage,
            25
        );

        $nbPages = (int)(ceil(count($modeles) / 25));

        if ($nbPages === 0) {
            $nbPages = 1;
        }

        if ($numPage > $nbPages) {
            throw $this->createNotFoundException();
        }

        return $this->render('modele/modeles.html.twig', [
            'num_page' => $numPage,
            'nb_pages' => $nbPages,
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
     *
     * @param Request $request
     * @param int $id L'identifiant du modèle à éditer
     *
     * @return RedirectResponse|Response
     */
    public function editer(Request $request, int $id): Response {
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
     *
     * @param Request $request
     * @param int $id L'identifiant du modèle à supprimer
     *
     * @return RedirectResponse|Response
     */
    public function supprimer(Request $request, int $id): Response {
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
            $em->remove($modele);
            $em->flush();

            $this->addFlash('success', 'Modèle supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_modeles');
        }

        return $this->render('modele/supprimer.html.twig', [
            'modele' => $modele,
            'form' => $form->createView(),
        ]);
    }
}
