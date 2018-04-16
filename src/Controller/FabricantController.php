<?php
// src/Controller/FabricantController.php

namespace App\Controller;

use App\Entity\Fabricant;
use App\Form\FabricantType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FabricantController extends Controller {
    /**
     * @Route(
     *     "/fabricant/nouveau",
     *     name="base_materiel_fabricant_nouveau",
     * )
     */
    public function nouveau(Request $request) {
        $fabricant = new Fabricant();

        $form = $this->createForm(FabricantType::class, $fabricant);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this
                    ->getDoctrine()
                    ->getManager()
                ;

                $em->persist($fabricant);
                $em->flush();

                $this->addFlash('success', 'Fabricant ajouté avec succés.');

                return $this->redirectToRoute('base_materiel_fabricant_liste');
            }
        }

        return $this->render('fabricant/nouveau.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/fabricants",
     *     name="base_materiel_fabricant_liste",
     * )
     */
    public function liste() {
        $fabricantRepository = $this
            ->getDoctrine()
            ->getRepository(Fabricant::class)
        ;

        $fabricants = $fabricantRepository->findAll();

        return $this->render('fabricant/liste.html.twig', [
            'fabricants' => $fabricants,
        ]);
    }

    /**
     * @Route(
     *     "/fabricant/editer/{slug}",
     *     name="base_materiel_fabricant_editer",
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

        $fabricantRepository = $em->getRepository(Fabricant::class);

        $fabricant = $fabricantRepository->findOneBy([
            'slug' => $slug,
        ]);

        if ($fabricant === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(FabricantType::class, $fabricant);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();

                $this->addFlash('success', 'Fabricant modifié avec succès.');

                return $this->redirectToRoute('base_materiel_fabricant_liste');
            }
        }

        return $this->render('fabricant/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/fabricant/supprimer/{slug}",
     *     name="base_materiel_fabricant_supprimer",
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

        $fabricantRepository = $em->getRepository(Fabricant::class);

        $fabricant = $fabricantRepository->findOneBy([
            'slug' => $slug,
        ]);

        if ($fabricant === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($fabricant);
                $em->flush();

                $this->addFlash('success', 'Fabricant supprimé avec succès.');

                return $this->redirectToRoute('base_materiel_fabricant_liste');
            }
        }

        return $this->render('fabricant/supprimer.html.twig', [
            'fabricant' => $fabricant,
            'form' => $form->createView(),
        ]);
    }
}
