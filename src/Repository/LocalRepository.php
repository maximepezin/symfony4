<?php
// src/Repository/LocalRepository.php

namespace App\Repository;

use App\Entity\Local;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe LocalRepository
 *
 * @package App\Repository
 *
 * @method Local|null find($id, $lockMode = null, $lockVersion = null)
 * @method Local|null findOneBy(array $criteria, array $orderBy = null)
 * @method Local[]    findAll()
 * @method Local[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Local::class);
    }

    /**
     * @return Local[]
     */
    public function getLocaux() {
        $query = $this
            ->createQueryBuilder('l')
            ->innerJoin('l.batiment', 'b')
            ->addSelect('b')
            ->addOrderBy('b.nom', 'ASC')
            ->addOrderBy('l.nom', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
