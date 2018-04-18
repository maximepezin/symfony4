<?php
// src/Form/ModeleType.php

namespace App\Form;

use App\Entity\Fabricant;
use App\Entity\Modele;
use App\Entity\TypeMateriel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeleType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Modèle',
            ])
            ->add('fabricant', EntityType::class, [
                'label' => 'Fabricant',
                'class' => Fabricant::class,
                'choice_label' => function($choice) {
                    return $choice->getNom();
                }
            ])
            ->add('typeMateriel', EntityType::class, [
                'label' => 'Type de matériel',
                'class' => TypeMateriel::class,
                'choice_label' => function($choice) {
                    return $choice->getLibelle();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Modele::class,
        ]);
    }
}
