<?php
// src/Repository/FabricantRepository.php

namespace App\Repository;

use App\Entity\Fabricant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
     * Retourne un objet de pagination contenant la collection de Fabricant dans un intervalle donné,
     * calculé en fonction du numéro de page et du nombre d'items passés en paramètres
     *
     * @param int $numPage Le numéro de la page
     * @param int $nbItems Le nombre d'items à sélectionner
     *
     * @return Paginator
     */
    public function getPaginationFabricants(int $numPage, int $nbItems): Paginator {
        $query = $this
            ->getFabricantsQueryBuilder()
            ->orderBy('f.nom', 'ASC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($numPage - 1) * $nbItems)
            ->setMaxResults($nbItems)
        ;

        return new Paginator($query, true);
    }
}
