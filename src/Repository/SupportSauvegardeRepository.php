<?php
// src/Repository/SupportSauvegardeRepository.php

namespace App\Repository;

use App\Entity\SupportSauvegarde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe SupportSauvegardeRepository
 *
 * @package App\Repository
 *
 * @method SupportSauvegarde|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupportSauvegarde|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupportSauvegarde[]    findAll()
 * @method SupportSauvegarde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportSauvegardeRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, SupportSauvegarde::class);
    }

    /**
     * @return SupportSauvegarde[]
     */
    public function getSupportsSauvegarde() {
        $query = $this
            ->createQueryBuilder('ss')
            ->addOrderBy('ss.libelle', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
