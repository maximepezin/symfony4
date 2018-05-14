<?php
// src/Repository/DomaineRepository.php

namespace App\Repository;

use App\Entity\Domaine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Classe DomaineRepository
 *
 * @package App\Repository
 *
 * @method Domaine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Domaine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Domaine[]    findAll()
 * @method Domaine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomaineRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Domaine::class);
    }

    /**
     * @return Domaine[]
     */
    public function getDomaines() {
        $query = $this
            ->createQueryBuilder('d')
            ->addOrderBy('d.nom', 'ASC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
