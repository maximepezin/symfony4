<?php
// src/Form/MaterielRechercheRapideType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielRechercheRapideType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du matériel',
                'required' => false,
            ])
            ->add('adresseIpV4', TextType::class, [
                'label' => 'Adresse IPv4',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
