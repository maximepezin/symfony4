<?php
// src/DataFixtures/DomaineFixtures.php

namespace App\DataFixtures;

use App\Entity\Domaine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DomaineFixtures extends Fixture {
    public const WORKGROUP_REFERENCE = 'workgroup';

    public function load(ObjectManager $manager) {
        $workgroup = new Domaine();
        $workgroup->setNom('WORKGROUP');

        $manager->persist($workgroup);
        $manager->flush();

        $this->addReference(DomaineFixtures::WORKGROUP_REFERENCE, $workgroup);
    }
}
