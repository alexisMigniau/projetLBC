<?php

namespace App\Repository;

use App\Entity\PraticiensRegion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PraticiensRegion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PraticiensRegion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PraticiensRegion[]    findAll()
 * @method PraticiensRegion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PraticiensRegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PraticiensRegion::class);
    }

    // /**
    //  * @return PraticiensRegion[] Returns an array of PraticiensRegion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PraticiensRegion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
