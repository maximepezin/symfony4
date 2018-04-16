<?php

namespace App\Repository;

use App\Entity\Sauvegarde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Sauvegarde|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sauvegarde|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sauvegarde[]    findAll()
 * @method Sauvegarde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SauvegardeRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Sauvegarde::class);
    }
}
