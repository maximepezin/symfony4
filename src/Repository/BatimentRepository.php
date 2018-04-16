<?php

namespace App\Repository;

use App\Entity\Batiment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Batiment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Batiment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Batiment[]    findAll()
 * @method Batiment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BatimentRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Batiment::class);
    }
}
