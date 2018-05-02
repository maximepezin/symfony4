<?php
// src/Controller/LocalController.php

namespace App\Controller;

use App\Entity\Local;
use App\Form\LocalType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LocalController extends Controller {
    /**
     * @Route(
     *     "/local/ajouter",
     *     name="base_materiel_local_ajouter",
     * )
     */
    public function ajouter(Request $request) {
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
     */
    public function locaux() {
        $localRepository = $this
            ->getDoctrine()
            ->getRepository(Local::class)
        ;

        $locaux = $localRepository->findAll();

        return $this->render('local/locaux.html.twig', [
            'locaux' => $locaux
        ]);
    }
}
