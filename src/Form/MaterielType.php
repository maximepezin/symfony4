<?php
// src/Form/MaterielType.php

namespace App\Form;

use App\Entity\Domaine;
use App\Entity\Emplacement;
use App\Entity\Materiel;
use App\Entity\Modele;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('modele', EntityType::class, [
                'label' => 'Modèle',
                'required' => false,
                'class' => Modele::class,
                'choice_label' => function($choice) {
                    return $choice->getFabricant()->getNom() . ' - ' . $choice->getNom();
                },
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('acheteLe', DateType::class, [
                'label' => 'Acheté le',
                'required' => false,
            ])
            ->add('numeroSerie', TextType::class, [
                'label' => 'Numéro de série',
                'required' => false,
            ])
            ->add('antivirusInstalle', CheckboxType::class, [
                'label' => 'Antivirus installé',
                'required' => false,
            ])
            ->add('estMajViaWsus', CheckboxType::class, [
                'label' => 'Est mis à jour via WSUS',
                'required' => false,
            ])
            ->add('estReferenceGlpi', CheckboxType::class, [
                'label' => 'Est référencé dans la GLPI',
                'required' => false,
            ])
            ->add('estActifReseau', CheckboxType::class, [
                'label' => 'Est actif sur le réseau',
                'required' => false,
            ])
            ->add('estPieceRechange', CheckboxType::class, [
                'label' => 'Est une pièce de rechange',
                'required' => false,
            ])
            ->add('domaine', EntityType::class, [
                'label' => 'Domaine',
                'required' => false,
                'class' => Domaine::class,
                'choice_label' => function($choice) {
                    return $choice->getNom();
                },
            ])
            ->add('emplacement', EntityType::class, [
                'label' => 'Bâtiment / Local / Emplacement',
                'required' => false,
                'class' => Emplacement::class,
                'choice_label' => function($choice) {
                    return $choice->getLocal()->getBatiment()->getNom() . ' / ' . $choice->getLocal()->getNom() . ' / ' . $choice->getNom();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
