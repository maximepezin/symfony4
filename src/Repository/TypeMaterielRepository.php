<?php
// src/Repository/TypeMaterielRepository.php

namespace App\Repository;

use App\Entity\TypeMateriel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe TypeMaterielRepository
 *
 * @package App\Repository
 *
 * @method TypeMateriel|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeMateriel|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeMateriel[]    findAll()
 * @method TypeMateriel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeMaterielRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, TypeMateriel::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getTypesMaterielQueryBuilder(): QueryBuilder {
        $queryBuilder = $this
            ->createQueryBuilder('tm')
            ->addOrderBy('tm.libelle', 'ASC')
        ;

        return $queryBuilder;
    }

    /**
     * @return TypeMateriel[]
     */
    public function getTypesMateriel() {
        return $this
            ->getTypesMaterielQueryBuilder()
            ->getQuery()
            ->getResult()
        ;
    }
}
