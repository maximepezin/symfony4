<?php

namespace App\Repository;

use App\Entity\MaterielPieceRechange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MaterielPieceRechange|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterielPieceRechange|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterielPieceRechange[]    findAll()
 * @method MaterielPieceRechange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterielPieceRechangeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MaterielPieceRechange::class);
    }

//    /**
//     * @return MaterielPieceRechange[] Returns an array of MaterielPieceRechange objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MaterielPieceRechange
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
