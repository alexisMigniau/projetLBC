<?php

namespace App\Repository;

use App\Entity\Quotamedicament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Quotamedicament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quotamedicament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quotamedicament[]    findAll()
 * @method Quotamedicament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuotamedicamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quotamedicament::class);
    }

    // /**
    //  * @return Quotamedicament[] Returns an array of Quotamedicament objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Quotamedicament
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
