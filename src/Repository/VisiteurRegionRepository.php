<?php

namespace App\Repository;

use App\Entity\VisiteurRegion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VisiteurRegion|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisiteurRegion|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisiteurRegion[]    findAll()
 * @method VisiteurRegion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteurRegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisiteurRegion::class);
    }

    public function getVisiteurByIdRegion($regCode)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.regCode = :regCode')
            ->andWhere('v.active = 1')
            ->leftJoin('App\Entity\Profil' , 'p', 'WITH' , 'v.matricule = p.id')
            ->setParameter('regCode' , $regCode)
            ->select('(v.matricule)' , '(p.prenom)' ,'(p.nom)')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return VisiteurRegion[] Returns an array of VisiteurRegion objects
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
    public function findOneBySomeField($value): ?VisiteurRegion
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
