<?php

namespace App\Repository;

use App\Entity\Stockmedicament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Stockmedicament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stockmedicament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stockmedicament[]    findAll()
 * @method Stockmedicament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockmedicamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stockmedicament::class);
    }

    // /**
    //  * @return Stockmedicament[] Returns an array of Stockmedicament objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stockmedicament
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
