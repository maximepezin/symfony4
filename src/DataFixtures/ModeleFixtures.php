<?php
// src/DataFixtures/ModeleFixtures.php

namespace App\DataFixtures;

use App\Entity\Modele;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ModeleFixtures extends Fixture implements DependentFixtureInterface {
    public const ORACLE_VM_VIRTUAL_BOX_REFERENCE = 'oracle-vm-virtual-box';

    public function load(ObjectManager $manager) {
        $oracleVmVirtualBox = new Modele();
        $oracleVmVirtualBox
            ->setTypeMateriel($this->getReference(TypeMaterielFixtures::MACHINE_VIRTUELLE_REFERENCE))
            ->setFabricant($this->getReference(FabricantFixtures::ORACLE_CORPORATION_REFERENCE))
            ->setNom('Oracle VM VirtualBox')
        ;

        $manager->persist($oracleVmVirtualBox);
        $manager->flush();

        $this->addReference(ModeleFixtures::ORACLE_VM_VIRTUAL_BOX_REFERENCE, $oracleVmVirtualBox);
    }

    public function getDependencies() {
        return [
            TypeMaterielFixtures::class,
            FabricantFixtures::class,
        ];
    }
}
