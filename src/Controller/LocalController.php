<?php
// src/Controller/LocalController.php

namespace App\Controller;

use App\Entity\Local;
use App\Form\LocalType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Classe LocalController
 *
 * @package App\Controller
 */
class LocalController extends Controller {
    /**
     * @Route(
     *     "/local/ajouter",
     *     name="base_materiel_local_ajouter",
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(Request $request): Response {
        $local = new Local();

        $form = $this->createForm(LocalType::class, $local);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($local);
            $em->flush();

            $this->addFlash('success', 'Local ajouté avec succès.');

            return $this->redirectToRoute('base_materiel_locaux');
        }

        return $this->render('local/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/locaux",
     *     name="base_materiel_locaux",
     * )
     *
     * @return Response
     */
    public function locaux(): Response {
        $localRepository = $this
            ->getDoctrine()
            ->getRepository(Local::class)
        ;

        $locaux = $localRepository->getLocaux();

        return $this->render('local/locaux.html.twig', [
            'locaux' => $locaux
        ]);
    }

    /**
     * @Route(
     *     "/local/editer/{id}",
     *     name="base_materiel_local_editer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant du local à éditer
     *
     * @return RedirectResponse|Response
     */
    public function editer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $localRepository = $em->getRepository(Local::class);

        $local = $localRepository->find($id);

        if ($local === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(LocalType::class, $local);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Local modifié avec succès.');

            return $this->redirectToRoute('base_materiel_locaux');
        }

        return $this->render('local/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/local/supprimer/{id}",
     *     name="base_materiel_local_supprimer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant du local à supprimer
     *
     * @return RedirectResponse|Response
     */
    public function supprimer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $localRepository = $em->getRepository(Local::class);

        $local = $localRepository->find($id);

        if ($local === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($local);
            $em->flush();

            $this->addFlash('success', 'Local supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_locaux');
        }

        return $this->render('local/supprimer.html.twig', [
            'local' => $local,
            'form' => $form->createView(),
        ]);
    }
}
