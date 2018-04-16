<?php

namespace App\Repository;

use App\Entity\SupportSauvegarde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SupportSauvegarde|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupportSauvegarde|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupportSauvegarde[]    findAll()
 * @method SupportSauvegarde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportSauvegardeRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, SupportSauvegarde::class);
    }
}
