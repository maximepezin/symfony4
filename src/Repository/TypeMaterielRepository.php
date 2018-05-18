<?php
// src/Repository/TypeMaterielRepository.php

namespace App\Repository;

use App\Entity\TypeMateriel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
     * Retourne un objet de pagination contenant la collection de TypeMateriel dans un intervalle donné,
     * calculé en fonction du numéro de page et du nombre d'items passés en paramètres
     *
     * @param int $numPage Le numéro de la page
     * @param int $nbItems Le nombre d'items à sélectionner
     *
     * @return Paginator
     */
    public function getPaginationTypesMateriel(int $numPage, int $nbItems): Paginator {
        $query = $this
            ->getTypesMaterielQueryBuilder()
            ->getQuery()
        ;

        $query
            ->setFirstResult(($numPage - 1) * $nbItems)
            ->setMaxResults($nbItems)
        ;

        return new Paginator($query, true);
    }
}
