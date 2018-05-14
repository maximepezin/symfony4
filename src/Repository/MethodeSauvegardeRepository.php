<?php
// src/Repository/MethodeSauvegardeRepository.php

namespace App\Repository;

use App\Entity\MethodeSauvegarde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe MethodeSauvegardeRepository
 *
 * @package App\Repository
 *
 * @method MethodeSauvegarde|null find($id, $lockMode = null, $lockVersion = null)
 * @method MethodeSauvegarde|null findOneBy(array $criteria, array $orderBy = null)
 * @method MethodeSauvegarde[]    findAll()
 * @method MethodeSauvegarde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MethodeSauvegardeRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, MethodeSauvegarde::class);
    }

    /**
     * @return MethodeSauvegarde[]
     */
    public function getMethodesSauvegarde() {
        $query = $this
            ->createQueryBuilder('ms')
            ->addOrderBy('ms.libelle', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
