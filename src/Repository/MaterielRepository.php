<?php
// src/Repository/MaterielRepository.php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe MaterielRepository
 *
 * @package App\Repository
 *
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
     * @param int $nbItems Le nombre d'items à sélectionner
     *
     * @return Paginator
     */
    public function getPaginationMateriels(int $numPage, int $nbItems): Paginator {
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
     * A RETRAVAILLER
     * Sélectionne et retourne un objet Materiel pleinement hydraté en fonction
     * du slug (clé unique) passé en paramètre ou null si aucun résultat
     *
     * @param string $slug Le slug du matériel à sélectionner
     *
     * @return Materiel|null
     *
     * @deprecated
     */
    public function getMaterielParSlug(string $slug) {
        $query = $this
            ->getQueryBuilder()
            ->leftJoin('m.domaine', 'd')
            ->addSelect('d')
            ->leftJoin('m.emplacement', 'e')
            ->addSelect('e')
            ->leftJoin('m.materielSystemesExploitation', 'mse')
            ->addSelect('mse')
            ->leftJoin('mse.systemeExploitation', 'se')
            ->addSelect('se')
            ->leftJoin('m.materielLogiciels', 'ml')
            ->addSelect('ml')
            ->leftJoin('ml.logiciel', 'l')
            ->addSelect('l')
            ->andWhere('m.slug LIKE :slug')
            ->setParameter(':slug', $slug)
            ->addOrderBy('se.nom', 'ASC')
            ->addOrderBy('l.nom', 'ASC')
            ->addOrderBy('ci.adresseIpV4', 'ASC')
            ->getQuery()
        ;

        try {
            $rs = $query->getOneOrNullResult();
        } catch (\Exception $exception) { // Inutile... mais évite que l'IDE râle
            $rs = null;
        }

        return $rs;
    }

    /**
     * Retourne un objet QueryBuilder permettant de sélectionner les matériels qui sont des pièces de rechange
     *
     * @return QueryBuilder
     */
    public function getQueryBuilderPourPiecesRechange(): QueryBuilder {
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
