<?php
// src/Controller/TypeMaterielController.php

namespace App\Controller;

use App\Entity\TypeMateriel;
use App\Form\TypeMaterielType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TypeMaterielController extends Controller {
    /**
     * @Route(
     *     "/type-materiel/nouveau",
     *     name="base_materiel_type_materiel_nouveau",
     * )
     */
    public function nouveau(Request $request) {
        $typeMateriel = new TypeMateriel();

        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this
                    ->getDoctrine()
                    ->getManager()
                ;

                $em->persist($typeMateriel);
                $em->flush();

                $this->addFlash('success', 'Type de matériel créé avec succés.');

                return $this->redirectToRoute('base_materiel_type_materiel_liste');
            }
        }

        return $this->render('type_materiel/nouveau.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/types-materiels",
     *     name="base_materiel_type_materiel_liste",
     * )
     */
    public function liste() {
        $typeMaterielRepository = $this
            ->getDoctrine()
            ->getRepository(TypeMateriel::class)
        ;

        $typesMateriel = $typeMaterielRepository->findAll();

        return $this->render('type_materiel/liste.html.twig', [
            'typesMateriel' => $typesMateriel,
        ]);
    }

    /**
     * @Route(
     *     "/type-materiel/editer/{slug}",
     *     name="base_materiel_type_materiel_editer",
     *     requirements={
     *         "slug": "[a-z0-9\-]+",
     *     },
     * )
     */
    public function editer(Request $request, string $slug) {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $typeMaterielRepository = $em->getRepository(TypeMateriel::class);

        $typeMateriel = $typeMaterielRepository->findOneBy([
            'slug' => $slug,
        ]);

        if ($typeMateriel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();

                $this->addFlash('success', 'Type de matériel modifié avec succès.');

                return $this->redirectToRoute('base_materiel_type_materiel_liste');
            }
        }

        return $this->render('type_materiel/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/type-materiel/supprimer/{slug}",
     *     name="base_materiel_type_materiel_supprimer",
     *     requirements={
     *         "slug": "[a-z0-9\-]+",
     *     },
     * )
     */
    public function supprimer(Request $request, string $slug) {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $typeMaterielRepository = $em->getRepository(TypeMateriel::class);

        $typeMateriel = $typeMaterielRepository->findOneBy([
            'slug' => $slug,
        ]);

        if ($typeMateriel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($typeMateriel);
                $em->flush();

                $this->addFlash('success', 'Type de matériel supprimé avec succès.');

                return $this->redirectToRoute('base_materiel_type_materiel_liste');
            }
        }

        return $this->render('type_materiel/supprimer.html.twig', [
            'typeMateriel' => $typeMateriel,
            'form' => $form->createView(),
        ]);
    }
}
