<?php
// src/Repository/MaterielPieceRechangeRepository.php

namespace App\Repository;

use App\Entity\MaterielPieceRechange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MaterielPieceRechange|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterielPieceRechange|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterielPieceRechange[]    findAll()
 * @method MaterielPieceRechange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterielPieceRechangeRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, MaterielPieceRechange::class);
    }
}
