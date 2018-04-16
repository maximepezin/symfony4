<?php
// src/Form/FabricantType.php

namespace App\Form;

use App\Entity\Fabricant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FabricantType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Fabricant',
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Fabricant::class,
            //'inherit_data' => true,
        ]);
    }
}
