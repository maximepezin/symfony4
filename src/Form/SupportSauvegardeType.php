<?php
// src/Form/SupportSauvegardeType.php

namespace App\Form;

use App\Entity\SupportSauvegarde;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupportSauvegardeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => SupportSauvegarde::class,
        ]);
    }
}
