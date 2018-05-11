<?php
// src/DataFixtures/ConfigurationIpFixtures.php

namespace App\DataFixtures;

use App\Entity\ConfigurationIp;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ConfigurationIpFixtures extends Fixture implements DependentFixtureInterface {
    public function load(ObjectManager $manager) {
        $configurationIp = new ConfigurationIp($this->getReference(MaterielFixtures::PCDEV_REFERENCE));
        $configurationIp
            ->setLibelle('enp0s3')
            ->setAdresseIpV4('10.0.2.15')
            ->setMasqueSousReseau('255.255.255.0')
        ;

        $manager->persist($configurationIp);
        $manager->flush();
    }

    public function getDependencies() {
        return [
            MaterielFixtures::class,
        ];
    }
}
