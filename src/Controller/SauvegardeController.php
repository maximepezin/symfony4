<?php
// src/Controller/SauvegardeController.php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Sauvegarde;
use App\Form\SauvegardeType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     *
     * @param Request $request
     * @param string $slugMateriel Le slug du matériel auquel associer la sauvegarde à ajouter
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(Request $request, string $slugMateriel): Response {
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
            'materiel' => $materiel,
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
     *
     * @param Request $request
     * @param string $slugMateriel  Le slug du matériel auquel est associé la sauvegarde à éditer
     * @param int $id               L'identifiant de la sauvegarde à éditer
     *
     * @return RedirectResponse|Response
     */
    public function editer(Request $request, string $slugMateriel, int $id): Response {
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

        $sauvegardeRepository = $em->getRepository(Sauvegarde::class);

        $sauvegarde = $sauvegardeRepository->findOneBy([
            'id' => $id,
            'materiel' => $materiel,
        ]);

        if ($sauvegarde === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(SauvegardeType::class, $sauvegarde);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Sauvegarde modifiée avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('sauvegarde/editer.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
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

        $sauvegardeRepository = $em->getRepository(Sauvegarde::class);

        $sauvegarde = $sauvegardeRepository->findOneBy([
            'id' => $id,
            'materiel' => $materiel,
        ]);

        if ($sauvegarde === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($sauvegarde);
            $em->flush();

            $this->addFlash('success', 'Sauvegarde supprimée avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('sauvegarde/supprimer.html.twig', [
            'materiel' => $materiel,
            'sauvegarde' => $sauvegarde,
            'form' => $form->createView(),
        ]);
    }
}
