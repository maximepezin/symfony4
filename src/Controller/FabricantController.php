<?php
// src/Controller/FabricantController.php

namespace App\Controller;

use App\Entity\Fabricant;
use App\Form\FabricantType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Classe FabricantController
 *
 * @package App\Controller
 */
class FabricantController extends Controller {
    /**
     * @Route(
     *     "/fabricant/ajouter",
     *     name="base_materiel_fabricant_ajouter",
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function ajouter(Request $request): Response {
        $fabricant = new Fabricant();

        $form = $this->createForm(FabricantType::class, $fabricant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager()
            ;

            $em->persist($fabricant);
            $em->flush();

            $this->addFlash('success', 'Fabricant ajouté avec succès.');

            return $this->redirectToRoute('base_materiel_fabricants');
        }

        return $this->render('fabricant/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/fabricants",
     *     name="base_materiel_fabricants",
     * )
     *
     * @return Response
     */
    public function fabricants(): Response {
        $fabricantRepository = $this
            ->getDoctrine()
            ->getRepository(Fabricant::class)
        ;

        $fabricants = $fabricantRepository->getFabricants();

        return $this->render('fabricant/fabricants.html.twig', [
            'fabricants' => $fabricants,
        ]);
    }

    /**
     * @Route(
     *     "/fabricant/editer/{id}",
     *     name="base_materiel_fabricant_editer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant du fabricant à éditer
     *
     * @return RedirectResponse|Response
     */
    public function editer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $fabricantRepository = $em->getRepository(Fabricant::class);

        $fabricant = $fabricantRepository->find($id);

        if ($fabricant === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(FabricantType::class, $fabricant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Fabricant modifié avec succès.');

            return $this->redirectToRoute('base_materiel_fabricants');
        }

        return $this->render('fabricant/editer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/fabricant/supprimer/{id}",
     *     name="base_materiel_fabricant_supprimer",
     *     requirements={
     *         "id": "\d+",
     *     },
     * )
     *
     * @param Request $request
     * @param int $id L'identifiant du fabricant à supprimer
     *
     * @return RedirectResponse|Response
     */
    public function supprimer(Request $request, int $id): Response {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $fabricantRepository = $em->getRepository(Fabricant::class);

        $fabricant = $fabricantRepository->find($id);

        if ($fabricant === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($fabricant);
            $em->flush();

            $this->addFlash('success', 'Fabricant supprimé avec succès.');

            return $this->redirectToRoute('base_materiel_fabricants');
        }

        return $this->render('fabricant/supprimer.html.twig', [
            'fabricant' => $fabricant,
            'form' => $form->createView(),
        ]);
    }
}
