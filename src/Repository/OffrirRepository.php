<?php

namespace App\Repository;

use App\Entity\Offrir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Offrir|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offrir|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offrir[]    findAll()
 * @method Offrir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffrirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offrir::class);
    }

    // /**
    //  * @return Offrir[] Returns an array of Offrir objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Offrir
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
