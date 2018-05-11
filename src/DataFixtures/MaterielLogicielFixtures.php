<?php
// src/DataFixtures/MaterielLogicielFixtures.php

namespace App\DataFixtures;

use App\Entity\MaterielLogiciel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MaterielLogicielFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
        $materielLogiciel = new MaterielLogiciel($this->getReference(MaterielFixtures::PCDEV_REFERENCE));
        $materielLogiciel
            ->setLogiciel($this->getReference(LogicielFixtures::JET_BRAINS_PHP_STORM_IDE_V_2018_1_REFERENCE))
            ->setInstalleLe(new \DateTime('now'))
        ;

        $manager->persist($materielLogiciel);
        $manager->flush();
    }

    public function getDependencies() {
        return [
            MaterielFixtures::class,
            LogicielFixtures::class,
        ];
    }
}
