<?php

namespace App\Repository;

use App\Entity\Valide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Valide|null find($id, $lockMode = null, $lockVersion = null)
 * @method Valide|null findOneBy(array $criteria, array $orderBy = null)
 * @method Valide[]    findAll()
 * @method Valide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Valide::class);
    }

    // /**
    //  * @return Valide[] Returns an array of Valide objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Valide
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
