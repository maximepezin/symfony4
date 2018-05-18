<?php
// src/Repository/ModeleRepository.php

namespace App\Repository;

use App\Entity\Modele;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe ModeleRepository
 *
 * @package App\Repository
 *
 * @method Modele|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modele|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modele[]    findAll()
 * @method Modele[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeleRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Modele::class);
    }

    /**
     * @return QueryBuilder
     */
    public function getModelesQueryBuilder(): QueryBuilder {
        return $this
            ->createQueryBuilder('m')
            ->innerJoin('m.fabricant', 'f')
            ->addSelect('f')
            ->innerJoin('m.typeMateriel', 'tm')
            ->addSelect('tm')
        ;
    }

    /**
     * Retourne un objet de pagination contenant la collection de Modele dans un intervalle donné,
     * calculé en fonction du numéro de page et du nombre d'items passés en paramètres
     *
     * @param int $numPage Le numéro de la page
     * @param int $nbItems Le nombre d'items à sélectionner
     *
     * @return Paginator
     */
    public function getPaginationModeles(int $numPage, int $nbItems): Paginator {
        $query = $this
            ->getModelesQueryBuilder()
            ->addOrderBy('f.nom', 'ASC')
            ->addOrderBy('m.nom', 'ASC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($numPage - 1) * $nbItems)
            ->setMaxResults($nbItems)
        ;

        return new Paginator($query, true);
    }
}
