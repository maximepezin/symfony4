<?php
// src/Controller/ConfigurationIpController.php

namespace App\Controller;

use App\Entity\ConfigurationIp;
use App\Entity\Materiel;
use App\Form\ConfigurationIpType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfigurationIpController extends Controller {
    /**
     * @Route(
     *     "/materiel/{slugMateriel}/configuration-ip/ajouter",
     *     name="base_materiel_configuration_ip_ajouter",
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

        $configurationIp = new ConfigurationIp($materiel);

        $form = $this->createForm(ConfigurationIpType::class, $configurationIp);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($configurationIp);
            $em->flush();

            $this->addFlash('success', 'Configuration IP ajoutée avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('configuration_ip/ajouter.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/materiel/{slugMateriel}/configuration-ip/editer/{id}",
     *     name="base_materiel_configuration_ip_editer",
     *     requirements={
     *         "slugMateriel": "[a-z0-9\-]+",
     *         "id": "\d+",
     *     },
     * )
     */
    public function editer(Request $request, string $slugMateriel, int $id) {
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

        $configurationIpRepository = $em->getRepository(ConfigurationIp::class);

        $configurationIp = $configurationIpRepository->findOneBy([
            'materiel' => $materiel,
            'id' => $id,
        ]);

        if ($configurationIp === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ConfigurationIpType::class, $configurationIp);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Configuration IP modifiée avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('configuration_ip/editer.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/materiel/{slugMateriel}/configuration-ip/supprimer/{id}",
     *     name="base_materiel_configuration_ip_supprimer",
     *     requirements={
     *         "slugMateriel": "[a-z0-9\-]+",
     *         "id": "\d+",
     *     },
     * )
     */
    public function supprimer(Request $request, string $slugMateriel, int $id) {
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

        $configurationIpRepository = $em->getRepository(ConfigurationIp::class);

        $configurationIp = $configurationIpRepository->findOneBy([
            'materiel' => $materiel,
            'id' => $id,
        ]);

        if ($configurationIp === null) {
            throw $this->createNotFoundException();
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($configurationIp);
            $em->flush();

            $this->addFlash('success', 'Configuration IP supprimée avec succès.');

            return $this->redirectToRoute('base_materiel_materiel_visualiser', [
                'slug' => $materiel->getSlug(),
            ]);
        }

        return $this->render('configuration_ip/supprimer.html.twig', [
            'materiel' => $materiel,
            'configuration_ip' => $configurationIp,
            'form' => $form->createView(),
        ]);
    }
}
