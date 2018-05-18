<?php
// src/Controller/TypeMaterielController.php

namespace App\Controller;

use App\Entity\TypeMateriel;
use App\Form\TypeMaterielType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Classe TypeMaterielController
 *
 * @package App\Controller
 */
class TypeMaterielController extends Controller {
    /**
     * @Route(
     *     "/type-materiel/ajouter",
     *     name="base_materiel_type_materiel_ajouter",
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(Request $request): Response {
        $typeMateriel = new TypeMateriel();

        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($typeMateriel);
            $em->flush();

            $this->addFlash('success', 'Type de matériel ajouté avec succès.');

            return $this->redirectToRoute('base_materiel_types_materiel');
        }

        return $this->render('type_materiel/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/types-materiels/{numPage}",
     *     name="base_materiel_types_materiel",
     *     requirements={
     *         "numPage": "\d+",
     *     },
     *     defaults={
     *         "numPage": 1,
     *     },
     * )
     *
     * @param int $numPage Le numéro de la page à afficher
     *
     * @return Response
     */
    public function typesMateriel(int $numPage = 1): Response {
        if ($numPage < 1) {
            throw $this->createNotFoundException();
        }

        $typeMaterielRepository = $this
            ->getDoctrine()
            ->getRepository(TypeMateriel::class)
        ;

        $typesMateriel = $typeMaterielRepository->getPaginationTypesMateriel(
            $numPage,
            25
        );

        $nbPages = (int)(ceil(count($typesMateriel) / 25));

        if ($nbPages === 0) {
            $nbPages = 1;
        }

        if ($numPage > $nbPages) {
            throw $this->createNotFoundException();
        }

        return $this->render('type_materiel/types_materiel.html.twig', [
            'num_page' => $numPage,
            'nb_pages' => $nbPages,
            'types_materiel' => $typesMateriel,
        ]);
    }

    /**
     * @Route(
     *     "/type-materiel/editer/{id}",
     *     name="base_materiel_type_materiel_editer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant du type de matériel à éditer
     *
     * @return RedirectResponse|Response
     */
    public function editer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $typeMaterielRepository = $em->getRepository(TypeMateriel::class);

        $typeMateriel = $typeMaterielRepository->find($id);

        if ($typeMateriel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(TypeMaterielType::class, $typeMateriel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Type de matériel modifié avec succès.');

            return $this->redirectToRoute('base_materiel_types_materiel');
        }

        return $this->render('type_materiel/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/type-materiel/supprimer/{id}",
     *     name="base_materiel_type_materiel_supprimer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant du type de matériel à supprimer
     *
     * @return RedirectResponse|Response
     */
    public function supprimer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $typeMaterielRepository = $em->getRepository(TypeMateriel::class);

        $typeMateriel = $typeMaterielRepository->find($id);

        if ($typeMateriel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($typeMateriel);
            $em->flush();

            $this->addFlash('success', 'Type de matériel supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_types_materiel');
        }

        return $this->render('type_materiel/supprimer.html.twig', [
            'type_materiel' => $typeMateriel,
            'form' => $form->createView(),
        ]);
    }
}
