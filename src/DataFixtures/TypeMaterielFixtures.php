<?php
// src/DataFixtures/TypeMaterielFixtures.php

namespace App\DataFixtures;

use App\Entity\TypeMateriel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeMaterielFixtures extends Fixture {
    public const MACHINE_VIRTUELLE_REFERENCE = 'machine-virtuelle';

    public function load(ObjectManager $manager) {
        $machineVirtuelle = new TypeMateriel();
        $machineVirtuelle->setLibelle('Machine virtuelle');

        $manager->persist($machineVirtuelle);
        $manager->flush();

        $this->addReference(TypeMaterielFixtures::MACHINE_VIRTUELLE_REFERENCE, $machineVirtuelle);
    }
}
