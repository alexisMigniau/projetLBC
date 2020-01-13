<?php

namespace App\Repository;

use App\Entity\Horsforfait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Horsforfait|null find($id, $lockMode = null, $lockVersion = null)
 * @method Horsforfait|null findOneBy(array $criteria, array $orderBy = null)
 * @method Horsforfait[]    findAll()
 * @method Horsforfait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HorsforfaitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Horsforfait::class);
    }

    // /**
    //  * @return Horsforfait[] Returns an array of Horsforfait objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Horsforfait
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
