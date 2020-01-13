<?php

namespace App\Repository;

use App\Entity\Praticiens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Praticiens|null find($id, $lockMode = null, $lockVersion = null)
 * @method Praticiens|null findOneBy(array $criteria, array $orderBy = null)
 * @method Praticiens[]    findAll()
 * @method Praticiens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PraticiensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Praticiens::class);
    }

    // /**
    //  * @return Praticiens[] Returns an array of Praticiens objects
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
    public function findOneBySomeField($value): ?Praticiens
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
