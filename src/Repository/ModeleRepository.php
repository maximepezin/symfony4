<?php
// src/Repository/ModeleRepository.php

namespace App\Repository;

use App\Entity\Modele;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     * @return Modele[]
     */
    public function getModeles() {
        $query = $this
            ->createQueryBuilder('m')
            ->innerJoin('m.fabricant', 'f')
            ->addSelect('f')
            ->innerJoin('m.typeMateriel', 'tm')
            ->addSelect('tm')
            ->addOrderBy('f.nom', 'ASC')
            ->addOrderBy('m.nom', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
