<?php
// src/Repository/LogicielRepository.php

namespace App\Repository;

use App\Entity\Logiciel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe LogicielRepository
 *
 * @package App\Repository
 *
 * @method Logiciel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logiciel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logiciel[]    findAll()
 * @method Logiciel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogicielRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Logiciel::class);
    }

    /**
     * @return Logiciel[]
     */
    public function getLogiciels() {
        $query = $this
            ->createQueryBuilder('l')
            ->addOrderBy('l.nom', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
