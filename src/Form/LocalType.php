<?php
// src/Form/LocalType.php

namespace App\Form;

use App\Entity\Batiment;
use App\Entity\Local;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('batiment', EntityType::class, [
                'label' => 'Bâtiment',
                'class' => Batiment::class,
                'choice_label' => function($choice) {
                    return $choice->getNom();
                },
            ])
            ->add('nom', TextType::class, [
                'label' => 'Local',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Local::class,
        ]);
    }
}
