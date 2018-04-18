<?php
// src/Repository/DomaineRepository.php

namespace App\Repository;

use App\Entity\Domaine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Domaine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Domaine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Domaine[]    findAll()
 * @method Domaine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomaineRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Domaine::class);
    }
}
