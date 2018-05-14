<?php
// src/Controller/SupportSauvegardeController.php

namespace App\Controller;

use App\Entity\SupportSauvegarde;
use App\Form\SupportSauvegardeType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SupportSauvegardeController extends Controller {
    /**
     * @Route(
     *     "/support-sauvegarde/ajouter",
     *     name="base_materiel_support_sauvegarde_ajouter",
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(Request $request): Response {
        $supportSauvegarde = new SupportSauvegarde();

        $form = $this->createForm(SupportSauvegardeType::class, $supportSauvegarde);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($supportSauvegarde);
            $em->flush();

            $this->addFlash('succcess', 'Support de sauvegarde ajouté avec succès');

            return $this->redirectToRoute('base_materiel_supports_sauvegarde');
        }

        return $this->render('support_sauvegarde/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/supports-sauvegarde",
     *     name="base_materiel_supports_sauvegarde",
     * )
     *
     * @return Response
     */
    public function supportsSauvegarde(): Response {
        $supportSauvegardeRepository = $this
            ->getDoctrine()
            ->getRepository(SupportSauvegarde::class)
        ;

        $supportsSauvegarde = $supportSauvegardeRepository->getSupportsSauvegarde();

        return $this->render('support_sauvegarde/supports_sauvegarde.html.twig', [
            'supports_sauvegarde' => $supportsSauvegarde,
        ]);
    }

    /**
     * @Route(
     *     "/support-sauvegarde/editer/{id}",
     *     name="base_materiel_support_sauvegarde_editer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant du support de sauvegarde à éditer
     *
     * @return RedirectResponse|Response
     */
    public function editer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $supportSauvegardeRepository = $em->getRepository(SupportSauvegarde::class);

        $supportSauvegarde = $supportSauvegardeRepository->find($id);

        if ($supportSauvegarde === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(SupportSauvegardeType::class, $supportSauvegarde);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Support de sauvegarde modifié avec succès.');

            return $this->redirectToRoute('base_materiel_supports_sauvegarde');
        }

        return $this->render('support_sauvegarde/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/support-sauvegarde/supprimer/{id}",
     *     name="base_materiel_support_sauvegarde_supprimer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant du support de sauvegarde à supprimer
     *
     * @return RedirectResponse|Response
     */
    public function supprimer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $supportSauvegardeRepository = $em->getRepository(SupportSauvegarde::class);

        $supportSauvegarde = $supportSauvegardeRepository->find($id);

        if ($supportSauvegarde === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($supportSauvegarde);
            $em->flush();

            $this->addFlash('success', 'Support de sauvegarde supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_supports_sauvegarde');
        }

        return $this->render('support_sauvegarde/supprimer.html.twig', [
            'support_sauvegarde' => $supportSauvegarde,
            'form' => $form->createView(),
        ]);
    }
}
