<?php
// src/Repository/MaterielRepository.php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\OrderBy;
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

    public function getMaterielsPagine(int $page, int $nbItems) {
        $query = $this
            ->createQueryBuilder('m')
            ->orderBy('m.nom', 'ASC')
            ->getQuery()
        ;

        $query
            ->setFirstResult(($page - 1) * $nbItems)
            ->setMaxResults($nbItems)
        ;

        return new Paginator($query, true);
    }

    public function rechercher($nom, $adresseIpV4) {
        // A REVOIR...
        /*
        $queryBuilder = $this
            ->createQueryBuilder('m')
            ->leftJoin('m.configurationsIp', 'c')
            ->addSelect('c')
        ;

        if ($nom !== null) {
            $queryBuilder
                ->andWhere('m.nom LIKE :nom')
                ->setParameter(':nom', $nom)
            ;
        }

        if ($adresseIpV4 != null) {
            $adresseIpV4 = '%' . $adresseIpV4 . '%';

            $queryBuilder
                ->andWhere('c.adresseIpV4 LIKE :adresseIpV4')
                ->setParameter(':adresseIpV4', $adresseIpV4)
            ;
        }

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
        */
    }
}
