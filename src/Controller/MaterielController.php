<?php
// src/Controller/MaterielController.php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielRechercheRapideType;
use App\Form\MaterielType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MaterielController extends Controller {
    /**
     * @Route(
     *     "/materiel/ajouter",
     *     name="base_materiel_materiel_ajouter",
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(Request $request): Response {
        $materiel = new Materiel();

        $form = $this->createForm(MaterielType::class, $materiel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($materiel);
            $em->flush();

            $this->addFlash('success', "Matériel ajouté avec succès.");

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('materiel/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/materiels/{numPage}",
     *     name="base_materiel_materiels",
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
    public function materiels(int $numPage = 1): Response {
        if ($numPage < 1) {
            throw $this->createNotFoundException();
        }

        $materielRepository = $this
            ->getDoctrine()
            ->getRepository(Materiel::class)
        ;

        $materiels = $materielRepository->getPaginationMateriels(
            $numPage,
            Materiel::NOMBRE_ITEMS
        );

        $nbPages = (int)(ceil(count($materiels) / Materiel::NOMBRE_ITEMS));

        if ($nbPages === 0) {
            $nbPages = 1;
        }

        if ($numPage > $nbPages) {
            throw $this->createNotFoundException();
        }

        return $this->render('materiel/materiels.html.twig', [
            'materiels' => $materiels,
            'num_page' => $numPage,
            'nb_pages' => $nbPages,
        ]);
    }

    /**
     * @Route(
     *     "/materiel/visualiser/{slug}",
     *     name="base_materiel_materiel_visualiser",
     *     requirements={
     *         "slug": "[a-z0-9\-]+",
     *     },
     * )
     *
     * @param string $slug Le slug du matériel à visualiser
     *
     * @return Response
     */
    public function visualiser(string $slug): Response {
        $materielRepository = $this
            ->getDoctrine()
            ->getRepository(Materiel::class)
        ;

        $materiel = $materielRepository->getMaterielParSlug($slug);

        if ($materiel === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('materiel/visualiser.html.twig', [
            'materiel' => $materiel,
        ]);
    }

    /**
     * @Route(
     *     "/materiel/editer/{slug}",
     *     name="base_materiel_materiel_editer",
     *     requirements={
     *         "slug": "[a-z0-9\-]+",
     *     },
     * )
     *
     * @param Request $request
     * @param string $slug Le slug du matériel à éditer
     *
     * @return RedirectResponse|Response
     */
    public function editer(Request $request, string $slug): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $materielRepository = $em->getRepository(Materiel::class);

        $materiel = $materielRepository->getMaterielParSlug($slug);

        if ($materiel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(MaterielType::class, $materiel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', "Matériel modifié avec succès.");

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('materiel/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/materiel/supprimer/{slug}",
     *     name="base_materiel_materiel_supprimer",
     *     requirements={
     *         "slug": "[a-z0-9\-]+",
     *     },
     * )
     *
     * @param Request $request
     * @param string $slug Le slug du matériel à éditer
     *
     * @return RedirectResponse|Response
     */
    public function supprimer(Request $request, string $slug): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $materielRepo = $em->getRepository(Materiel::class);

        $materiel = $materielRepo->getMaterielParSlug($slug);

        if ($materiel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($materiel);
                $em->flush();

                $this->addFlash('success', "Matériel supprimé avec succès.");

                return $this->redirectToRoute('base_materiel_materiels');
            }
        }

        return $this->render('materiel/supprimer.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/materiel/recherche-rapide",
     *     name="base_materiel_materiel_recherche_rapide",
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function rechercheRapide(Request $request): Response {
        $form = $this->createForm(MaterielRechercheRapideType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $form->get('nom')->getData();
            $adresseIpV4 = $form->get('adresseIpV4')->getData();

            if ($nom === null && $adresseIpV4 === null) {
                $this->addFlash('danger', 'Veuillez saisir au moins un champ du formulaire de recherche rapide');

                return $this->redirectToRoute('base_materiel_materiel_recherche_rapide');
            }

            $materielRepository = $this
                ->getDoctrine()
                ->getRepository(Materiel::class)
            ;

            $materiels = $materielRepository->rechercheRapide(
                $nom,
                $adresseIpV4
            );

            return $this->render('materiel/recherche_rapide.html.twig', [
                'form' => $form->createView(),
                'materiels' => $materiels,
            ]);
        }

        return $this->render('materiel/recherche_rapide.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
