<?php
// src/Repository/FabricantRepository.php

namespace App\Repository;

use App\Entity\Fabricant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Fabricant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fabricant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fabricant[]    findAll()
 * @method Fabricant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FabricantRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Fabricant::class);
    }
}
