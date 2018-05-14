<?php
// src/Controller/BatimentController.php

namespace App\Controller;

use App\Entity\Batiment;
use App\Form\BatimentType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Classe BatimentController
 *
 * @package App\Controller
 */
class BatimentController extends Controller {
    /**
     * @Route(
     *     "/batiment/ajouter",
     *     name="base_materiel_batiment_ajouter",
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(Request $request): Response {
        $batiment = new Batiment();

        $form = $this->createForm(BatimentType::class, $batiment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($batiment);
            $em->flush();

            $this->addFlash('success', 'Bâtiment ajouté avec succès.');

            return $this->redirectToRoute('base_materiel_batiments');
        }

        return $this->render('batiment/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/batiments",
     *     name="base_materiel_batiments",
     * )
     *
     * @return Response
     */
    public function batiments(): Response {
        $batimentRepository = $this
            ->getDoctrine()
            ->getRepository(Batiment::class)
        ;

        $batiments = $batimentRepository->getBatiments();

        return $this->render('batiment/batiments.html.twig', [
            'batiments' => $batiments,
        ]);
    }

    /**
     * @Route(
     *     "/batiment/editer/{id}",
     *     name="base_materiel_batiment_editer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant du bâtiment à éditer
     *
     * @return RedirectResponse|Response
     */
    public function editer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $batimentRepository = $em->getRepository(Batiment::class);

        $batiment = $batimentRepository->find($id);

        if ($batiment === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(BatimentType::class, $batiment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Bâtiment modifié avec succès.');

            return $this->redirectToRoute('base_materiel_batiments');
        }

        return $this->render('batiment/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/batiment/supprimer/{id}",
     *     name="base_materiel_batiment_supprimer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant du bâtiment à supprimer
     *
     * @return RedirectResponse|Response
     */
    public function supprimer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $batimentRepository = $em->getRepository(Batiment::class);

        $batiment = $batimentRepository->find($id);

        if ($batiment === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($batiment);
            $em->flush();

            $this->addFlash('success', 'Bâtiment supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_batiments');
        }

        return $this->render('batiment/supprimer.html.twig', [
            'batiment' => $batiment,
            'form' => $form->createView(),
        ]);
    }
}
