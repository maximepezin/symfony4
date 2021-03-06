<?php
// src/Form/ConfigurationIpType.php

namespace App\Form;

use App\Entity\ConfigurationIp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationIpType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé',
                'required' => false,
            ])
            ->add('adresseIpV4', TextType::class, [
                'label' => 'Adresse IPv4',
            ])
            ->add('masqueSousReseau', TextType::class, [
                'label' => 'Masque de sous-réseau',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => ConfigurationIp::class,
        ]);
    }
}
