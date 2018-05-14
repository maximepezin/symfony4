<?php
// src/Repository/BatimentRepository.php

namespace App\Repository;

use App\Entity\Batiment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe BatimentRepository
 *
 * @package App\Repository
 *
 * @method Batiment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Batiment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Batiment[]    findAll()
 * @method Batiment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BatimentRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Batiment::class);
    }

    /**
     * return Batiment[]
     */
    public function getBatiments() {
        $query = $this
            ->createQueryBuilder('b')
            ->addOrderBy('b.nom', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
