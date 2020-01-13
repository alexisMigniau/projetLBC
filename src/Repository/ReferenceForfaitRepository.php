<?php

namespace App\Repository;

use App\Entity\ReferenceForfait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ReferenceForfait|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReferenceForfait|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReferenceForfait[]    findAll()
 * @method ReferenceForfait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferenceForfaitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReferenceForfait::class);
    }

    // /**
    //  * @return ReferenceForfait[] Returns an array of ReferenceForfait objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReferenceForfait
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
