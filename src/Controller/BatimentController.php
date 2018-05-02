<?php
// src/Controller/BatimentController.php

namespace App\Controller;

use App\Entity\Batiment;
use App\Form\BatimentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BatimentController extends Controller {
    /**
     * @Route(
     *     "/batiment/ajouter",
     *     name="base_materiel_batiment_ajouter",
     * )
     */
    public function ajouter(Request $request) {
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
     */
    public function batiments() {
        $batimentRepository = $this
            ->getDoctrine()
            ->getRepository(Batiment::class)
        ;

        $batiments = $batimentRepository->findAll();

        return $this->render('batiment/batiments.html.twig', [
            'batiments' => $batiments,
        ]);
    }
}
