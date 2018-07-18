<?php
// src/Form/MaterielPieceRechangeType.php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\MaterielPieceRechange;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielPieceRechangeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('pieceRechange', EntityType::class, [
                'label' => 'Pièce de rechange',
                'placeholder' => 'Choisir une pièce de rechange',
                'class' => Materiel::class,
                'choice_label' => function($choice) {
                    return $choice->getNom();
                },
            ])
            ->add('estUtilisee', CheckboxType::class, [
                'label' => 'Est utilisée',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => MaterielPieceRechange::class,
        ]);
    }
}
