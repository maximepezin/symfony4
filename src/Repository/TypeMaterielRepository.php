<?php
// src/Repository/TypeMaterielRepository.php

namespace App\Repository;

use App\Entity\TypeMateriel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     * @return TypeMateriel[]
     */
    public function getTypesMateriel() {
        $query = $this
            ->createQueryBuilder('tm')
            ->addOrderBy('tm.libelle', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
