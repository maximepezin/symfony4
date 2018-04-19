<?php
// src/Controller/DomaineController.php

namespace App\Controller;

use App\Entity\Domaine;
use App\Form\DomaineType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DomaineController extends Controller {
    /**
     * @Route(
     *     "/domaine/ajouter",
     *     name="base_materiel_domaine_ajouter",
     * )
     */
    public function ajouter(Request $request) {
        $domaine = new Domaine();

        $form = $this->createForm(DomaineType::class, $domaine);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($domaine);
            $em->flush();

            $this->addFlash('success', 'Domaine ajouté avec succès.');

            return $this->redirectToRoute('base_materiel_domaines');
        }

        return $this->render('domaine/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/domaines",
     *     name="base_materiel_domaines",
     * )
     */
    public function domaines() {
        $domaineRepository = $this
            ->getDoctrine()
            ->getRepository(Domaine::class)
        ;

        $domaines = $domaineRepository->findAll();

        return $this->render('domaine/domaines.html.twig', [
            'domaines' => $domaines,
        ]);
    }

    /**
     * @Route(
     *     "/domaine/editer/{id}",
     *     name="base_materiel_domaine_editer",
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

        $domaineRepository = $em->getRepository(Domaine::class);

        $domaine = $domaineRepository->find($id);

        if ($domaine === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(DomaineType::class, $domaine);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Domaine modifié avec succès.');

            return $this->redirectToRoute('base_materiel_domaines');
        }

        return $this->render('domaine/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/domaine/supprimer/{id}",
     *     name="base_materiel_domaine_supprimer",
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

        $domaineRepository = $em->getRepository(Domaine::class);

        $domaine = $domaineRepository->find($id);

        if ($domaine === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($domaine);
            $em->flush();

            $this->addFlash('success', 'Domaine supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_domaines');
        }

        return $this->render('domaine/supprimer.html.twig', [
            'domaine' => $domaine,
            'form' => $form->createView(),
        ]);
    }
}
