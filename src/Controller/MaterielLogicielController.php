<?php
// src/Controller/MaterielLogicielController.php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\MaterielLogiciel;
use App\Form\MaterielLogicielType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MaterielLogicielController extends Controller {
    /**
     * @Route(
     *     "/materiel/{slugMateriel}/logiciel/ajouter",
     *     name="base_materiel_materiel_logiciel_ajouter",
     *     requirements={
     *         "slugMateriel": "[a-z0-9\-]+",
     *     },
     * )
     */
    public function ajouter(Request $request, string $slugMateriel) {
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

        $materielLogiciel = new MaterielLogiciel($materiel);

        $form = $this->createForm(MaterielLogicielType::class, $materielLogiciel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($materielLogiciel);
            $em->flush();

            $this->addFlash('success', 'Logiciel ajouté avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('materiel_logiciel/ajouter.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }
}
