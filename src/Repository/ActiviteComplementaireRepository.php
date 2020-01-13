<?php

namespace App\Repository;

use App\Entity\ActiviteComplementaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActiviteComplementaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActiviteComplementaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActiviteComplementaire[]    findAll()
 * @method ActiviteComplementaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiviteComplementaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActiviteComplementaire::class);
    }

    // /**
    //  * @return ActiviteComplementaire[] Returns an array of ActiviteComplementaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActiviteComplementaire
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
