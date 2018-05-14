<?php
// src/Repository/MaterielRepository.php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Materiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Materiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Materiel[]    findAll()
 * @method Materiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterielRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Materiel::class);
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder() {
        $queryBuilder = $this
            ->createQueryBuilder('m')
            ->leftJoin('m.modele', 'm2')
            ->addSelect('m2')
            ->leftJoin('m2.typeMateriel', 'tm')
            ->addSelect('tm')
            ->leftJoin('m2.fabricant', 'f')
            ->addSelect('f')
            ->leftJoin('m.configurationsIp', 'ci')
            ->addSelect('ci')
        ;

        return $queryBuilder;
    }

    /**
     * Retourne un objet de pagination contenant la collection de Materiel dans un intervalle donné,
     * calculé en fonction du numéro de page et du nombre d'items passés en paramètres
     *
     * @param int $numPage Le numéro de la page
     * @param int $nbItems Le nombre d'items à sélectionner/afficher
     *
     * @return Paginator
     */
    public function getMaterielsAvecPagination(int $numPage, int $nbItems): Paginator {
        $query = $this
            ->getQueryBuilder()
            ->orderBy('m.nom', 'ASC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($numPage - 1) * $nbItems)
            ->setMaxResults($nbItems)
        ;

        return new Paginator($query, true);
    }

    /**
     * Retourne un objet QueryBuilder permettant de sélectionner les matériels qui sont des pièces de rechange
     *
     * @return QueryBuilder
     */
    public function getPiecesRechange(): QueryBuilder {
        $queryBuilder = $this
            ->createQueryBuilder('m')
            ->andWhere('m.estPieceRechange = true')
            ->addOrderBy('m.nom', 'ASC')
        ;

        return $queryBuilder;
    }

    /**
     * Méthode de recherche rapide
     *
     * @param null|string $nom          Le nom du matériel à rechercher
     * @param null|string $adresseIpV4  L'adresse IPv4 exacte du matériel à rechercher
     *
     * @return mixed
     */
    public function rechercheRapide(?string $nom, ?string $adresseIpV4) {
        $queryBuilder = $this->getQueryBuilder();

        if ($nom !== null) {
            $queryBuilder
                ->orWhere('m.nom LIKE :nom')
                ->setParameter(':nom', '%' . $nom . '%')
            ;
        }

        if ($adresseIpV4 !== null) {
            $queryBuilder
                ->orWhere('ci.adresseIpV4 LIKE :adresseIpV4')
                ->setParameter(':adresseIpV4', $adresseIpV4)
            ;
        }

        $queryBuilder
            ->addOrderBy('m.nom', 'ASC')
            ->addOrderBy('ci.adresseIpV4', 'ASC')
        ;

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }
}
