<?php
// src/DataFixtures/FabricantFixtures.php

namespace App\DataFixtures;

use App\Entity\Fabricant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FabricantFixtures extends Fixture {
    public const ORACLE_CORPORATION_REFERENCE = 'oracle-corporation';

    public function load(ObjectManager $manager) {
        $oracleCorporation = new Fabricant();
        $oracleCorporation->setNom('Oracle Corporation');

        $manager->persist($oracleCorporation);
        $manager->flush();

        $this->addReference(FabricantFixtures::ORACLE_CORPORATION_REFERENCE, $oracleCorporation);
    }
}
