<?php
// src/Controller/MaterielController.php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MaterielController extends Controller {
    /**
     * @Route(
     *     "/materiel/ajouter",
     *     name="base_materiel_materiel_ajouter",
     * )
     */
    public function ajouter(Request $request) {
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
     */
    public function materiels(int $numPage = 1) {
        if ($numPage < 1) {
            throw $this->createNotFoundException();
        }

        $materielRepository = $this
            ->getDoctrine()
            ->getRepository(Materiel::class)
        ;

        $materiels = $materielRepository->getMaterielsPagine(
            $numPage,
            Materiel::NOMBRE_ITEMS
        );

        $nbPages = ceil(count($materiels) / Materiel::NOMBRE_ITEMS);

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
     */
    public function visualiser(string $slug) {
        $materielRepository = $this
            ->getDoctrine()
            ->getRepository(Materiel::class)
        ;

        $materiel = $materielRepository->findOneBy([
            'slug' => $slug,
        ]);

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
     */
    public function editer(Request $request, string $slug) {
        $em = $this
            ->getDoctrine()
            ->getManager()
        ;

        $materielRepository = $em->getRepository(Materiel::class);

        $materiel = $materielRepository->findOneBy([
            'slug' => $slug,
        ]);

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
     *     "/materiel/ping/{slug}",
     *     name="base_materiel_materiel_ping",
     *     requirements={
     *         "slug": "[a-z0-9\-]+",
     *     },
     * )
     */
    public function ping(string $slug) {
        $materielRepository = $this
            ->getDoctrine()
            ->getRepository(Materiel::class)
        ;

        $materiel = $materielRepository->findOneBy([
            'slug' => $slug,
        ]);

        if ($materiel === null || $materiel->getConfigurationsIp()->isEmpty()) {
            throw $this->createNotFoundException();
        }

        $process = new Process('ping -n -c 1 ' . $materiel->getConfigurationsIp()->get(0)->getAdresseIp());

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo 'Pong !<br /><br />';
        echo nl2br($process->getOutput());
        die();
    }
}
