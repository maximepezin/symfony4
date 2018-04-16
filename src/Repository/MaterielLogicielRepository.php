<?php

namespace App\Repository;

use App\Entity\MaterielLogiciel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MaterielLogiciel|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterielLogiciel|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterielLogiciel[]    findAll()
 * @method MaterielLogiciel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterielLogicielRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, MaterielLogiciel::class);
    }
}
