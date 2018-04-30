<?php
// src/Repository/ConfigurationIpRepository.php

namespace App\Repository;

use App\Entity\ConfigurationIp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConfigurationIp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfigurationIp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfigurationIp[]    findAll()
 * @method ConfigurationIp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigurationIpRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, ConfigurationIp::class);
    }
}
