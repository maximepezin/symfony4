<?php
// src/DataFixtures/LogicielFixtures.php

namespace App\DataFixtures;

use App\Entity\Logiciel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LogicielFixtures extends Fixture {
    public const JET_BRAINS_PHP_STORM_IDE_V_2018_1REFERENCE = 'jet-brains-php-storm-ide-v-2018-1';

    public function load(ObjectManager $manager) {
        $jetBrainsPhpStormIdeV20181 = new Logiciel();
        $jetBrainsPhpStormIdeV20181->setNom('JetBrains PhpStorm IDE v.2018.1');

        $manager->persist($jetBrainsPhpStormIdeV20181);
        $manager->flush();

        $this->addReference(LogicielFixtures::JET_BRAINS_PHP_STORM_IDE_V_2018_1REFERENCE, $jetBrainsPhpStormIdeV20181);
    }
}
