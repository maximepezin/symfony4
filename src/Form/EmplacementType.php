<?php
// src/Form/EmplacementType.php

namespace App\Form;

use App\Entity\Emplacement;
use App\Entity\Local;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmplacementType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('local', EntityType::class, [
                'label' => 'Local',
                'placeholder' => 'Choisissez un local',
                'class' => Local::class,
                'choice_label' => function($choice) {
                    return $choice->getBatiment()->getNom() . ' - ' . $choice->getNom();
                },
            ])
            ->add('nom', TextType::class, [
                'label' => 'Emplacement',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Emplacement::class,
        ]);
    }
}
