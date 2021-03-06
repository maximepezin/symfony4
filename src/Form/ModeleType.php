<?php
// src/Form/ModeleType.php

namespace App\Form;

use App\Entity\Fabricant;
use App\Entity\Modele;
use App\Entity\TypeMateriel;
use App\Repository\FabricantRepository;
use App\Repository\TypeMaterielRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeleType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('typeMateriel', EntityType::class, [
                'label' => 'Type de matériel',
                'placeholder' => 'Choisir un type de matériel',
                'class' => TypeMateriel::class,
                'query_builder' => function(TypeMaterielRepository $typeMaterielRepository) {
                    return $typeMaterielRepository->getTypesMaterielQueryBuilder();
                },
                'choice_label' => function($choice) {
                    return $choice->getLibelle();
                },
            ])
            ->add('fabricant', EntityType::class, [
                'label' => 'Fabricant',
                'placeholder' => 'Choisir un fabricant',
                'class' => Fabricant::class,
                'query_builder' => function(FabricantRepository $fabricantRepository) {
                    return $fabricantRepository->getFabricantsQueryBuilder();
                },
                'choice_label' => function($choice) {
                    return $choice->getNom();
                },
            ])
            ->add('nom', TextType::class, [
                'label' => 'Modèle',
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Modele::class,
        ]);
    }
}
