<?php
// src/Form/MaterielLogicielType.php

namespace App\Form;

use App\Entity\Logiciel;
use App\Entity\MaterielLogiciel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielLogicielType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('logiciel', EntityType::class, [
                'label' => 'Logiciel',
                'placeholder' => 'Choisir un logiciel',
                'class' => Logiciel::class,
                'choice_label' => function($choice) {
                    return $choice->getNom();
                },
            ])
            ->add('installeLe', DateType::class, [
                'label' => 'Installé le',
                'required' => false,
            ])
            ->add('cleLicence', TextType::class, [
                'label' => 'Clé de licence',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => MaterielLogiciel::class,
        ]);
    }
}
