<?php

namespace App\Repository;

use App\Entity\Comptable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Comptable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comptable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comptable[]    findAll()
 * @method Comptable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComptableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comptable::class);
    }

    // /**
    //  * @return Comptable[] Returns an array of Comptable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comptable
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
