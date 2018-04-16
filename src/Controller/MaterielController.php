<?php
// src/Controller/MaterielController.php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MaterielController extends Controller {
    /**
     * @Route(
     *     "/materiel/nouveau",
     *     name="base_materiel_materiel_nouveau",
     * )
     */
    public function nouveau(Request $request) {
        $materiel = new Materiel();

        $form = $this->createForm(MaterielType::class, $materiel);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this
                    ->getDoctrine()
                    ->getManager()
                ;

                $em->persist($materiel);
                $em->flush();

                $this->addFlash('success', "Matériel créé avec succès.");

                return $this->redirectToRoute('base_materiel_materiel_voir', [
                    'slug' => $materiel->getSlug(),
                ]);
            }
        }

        return $this->render('materiel/nouveau.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/materiels",
     *     name="base_materiel_materiel_liste",
     * )
     */
    public function liste() {
        $materielRepo =	$this
            ->getDoctrine()
            ->getRepository(Materiel::class)
        ;

        $materiels = $materielRepo->findAll();

        return $this->render('materiel/liste.html.twig', [
            'materiels' => $materiels,
        ]);
    }

    /**
     * @Route(
     *     "/materiel/voir/{slug}",
     *     name="base_materiel_materiel_voir",
     *     requirements={
     *         "slug": "[a-z0-9\-]+",
     *     },
     * )
     */
    public function voir(string $slug) {
        $materielRepo = $this
            ->getDoctrine()
            ->getRepository(Materiel::class)
        ;

        $materiel = $materielRepo->findOneBy([
            'slug' => $slug,
        ]);

        if ($materiel === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('materiel/voir.html.twig', [
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
     */
    public function editer(Request $request, string $slug) {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $materielRepo = $em->getRepository(Materiel::class);

        $materiel = $materielRepo->findOneBy([
            'slug' => $slug,
        ]);

        if ($materiel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(MaterielType::class, $materiel);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();

                $this->addFlash('success', "Matériel modifié avec succès.");

                return $this->redirectToRoute('base_materiel_materiel_voir', [
                    'slug' => $materiel->getSlug(),
                ]);
            }
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
     */
    public function supprimer(Request $request, string $slug) {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $materielRepo = $em->getRepository(Materiel::class);

        $materiel = $materielRepo->findOneBy([
            'slug' => $slug,
        ]);

        if ($materiel === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($materiel);
                $em->flush();

                $this->addFlash('success', "Matériel supprimé avec succés.");

                return $this->redirectToRoute('base_materiel_materiel_liste');
            }
        }

        return $this->render('materiel/supprimer.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }
}
