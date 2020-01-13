<?php

namespace App\Repository;

use App\Entity\Forfaitaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Forfaitaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Forfaitaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Forfaitaires[]    findAll()
 * @method Forfaitaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForfaitairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Forfaitaires::class);
    }

    // /**
    //  * @return Forfaitaires[] Returns an array of Forfaitaires objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Forfaitaires
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
