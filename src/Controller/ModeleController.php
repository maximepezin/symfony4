<?php
// src/Controller/ModeleController.php

namespace App\Controller;

use App\Entity\Modele;
use App\Form\ModeleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModeleController extends Controller {
    /**
     * @Route(
     *     "/modele/nouveau",
     *     name="base_materiel_modele_nouveau",
     * )
     */
    public function nouveau(Request $request) {
        $modele = new Modele();

        $form = $this->createForm(ModeleType::class, $modele);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this
                    ->getDoctrine()
                    ->getManager()
                ;

                $em->persist($modele);
                $em->flush();

                $this->addFlash('success', 'Modèle créé avec succès.');

                return $this->redirectToRoute('base_materiel_modele_liste');
            }
        }

        return $this->render('modele/nouveau.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/modeles",
     *     name="base_materiel_modele_liste",
     * )
     */
    public function liste() {
        $modeleRepository = $this
            ->getDoctrine()
            ->getRepository(Modele::class)
        ;

        $modeles = $modeleRepository->findAll();

        return $this->render('modele/liste.html.twig', [
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

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();

                $this->addFlash('success', 'Modèle modidié avec succès.');

                return $this->redirectToRoute('base_materiel_modele_liste');
            }
        }

        return $this->render('modele/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function supprimer() {

    }
}
