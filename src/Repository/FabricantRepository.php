<?php
// src/Repository/FabricantRepository.php

namespace App\Repository;

use App\Entity\Fabricant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe FabricantRepository
 *
 * @package App\Repository
 *
 * @method Fabricant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fabricant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fabricant[]    findAll()
 * @method Fabricant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FabricantRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Fabricant::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getFabricantsQueryBuilder(): QueryBuilder {
        $queryBuilder = $this
            ->createQueryBuilder('f')
            ->addOrderBy('f.nom', 'ASC')
        ;

        return $queryBuilder;
    }

    /**
     * @return Fabricant[]
     */
    public function getFabricants() {
        return $this
            ->getFabricantsQueryBuilder()
            ->getQuery()
            ->getResult()
        ;
    }
}
