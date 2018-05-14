<?php
// src/Form/SauvegardeType.php

namespace App\Form;

use App\Entity\MethodeSauvegarde;
use App\Entity\Sauvegarde;
use App\Entity\SupportSauvegarde;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SauvegardeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('dateHeureSauvegarde', DateTimeType::class, [
                'label' => 'Date et heure de sauvegarde',
            ])
            ->add('auteur', TextType::class, [
                'label' => 'Auteur',
            ])
            ->add('methodeSauvegarde', EntityType::class, [
                'label' => 'Méthode de sauvegarde',
                'placeholder' => 'Choisir une méthode de sauvegarde',
                'class' => MethodeSauvegarde::class,
                'choice_label' => function($choice) {
                    return $choice->getLibelle();
                },
            ])
            ->add('supportSauvegarde', EntityType::class, [
                'label' => 'Support de sauvegarde',
                'placeholder' => 'Choisir un support de sauvegarde',
                'class' => SupportSauvegarde::class,
                'choice_label' => function($choice) {
                    return $choice->getLibelle();
                },
            ])
            ->add('cheminVersFichier', TextType::class, [
                'label' => 'Chemin vers le fichier de sauvegarde',
            ])
            ->add('nomFichierSauvegarde', TextType::class, [
                'label' => 'Nom du fichier de sauvegarde',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Sauvegarde::class,
        ]);
    }
}
