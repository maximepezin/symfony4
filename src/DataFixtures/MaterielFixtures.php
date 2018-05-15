<?php
// src/DataFixtures/MaterielFixtures.php

namespace App\DataFixtures;

use App\Entity\Materiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MaterielFixtures extends Fixture implements DependentFixtureInterface {
    public const PCDEV_REFERENCE = 'pcdev';

    public function load(ObjectManager $manager) {
        $pcdev = new Materiel();
        $pcdev
            ->setNom('pcdev')
            ->setModele($this->getReference(ModeleFixtures::ORACLE_VM_VIRTUAL_BOX_REFERENCE))
            ->setDescription("Machine virtuelle de développement Web")
            ->setEstActifReseau(true)
            ->setDomaine($this->getReference(DomaineFixtures::WORKGROUP_REFERENCE))
        ;

        $manager->persist($pcdev);
        $manager->flush();

        $this->addReference(MaterielFixtures::PCDEV_REFERENCE, $pcdev);
    }

    public function getDependencies() {
        return [
            ModeleFixtures::class,
            DomaineFixtures::class,
        ];
    }
}
