<?php
// src/Repository/EmplacementRepository.php

namespace App\Repository;

use App\Entity\Emplacement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe EmplacementRepository
 *
 * @package App\Repository
 *
 * @method Emplacement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emplacement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emplacement[]    findAll()
 * @method Emplacement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmplacementRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Emplacement::class);
    }

    /**
     * @return Emplacement[]
     */
    public function getEmplacements() {
        $query = $this
            ->createQueryBuilder('e')
            ->innerJoin('e.local', 'l')
            ->addSelect('l')
            ->innerJoin('l.batiment', 'b')
            ->addSelect('b')
            ->addOrderBy('b.nom', 'ASC')
            ->addOrderBy('l.nom', 'ASC')
            ->addOrderBy('e.nom', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
