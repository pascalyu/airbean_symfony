<?php

namespace App\Repository;

use App\Entity\AttractionPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AttractionPoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttractionPoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttractionPoint[]    findAll()
 * @method AttractionPoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttractionPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttractionPoint::class);
    }

    // /**
    //  * @return AttractionPoint[] Returns an array of AttractionPoint objects
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
    public function findOneBySomeField($value): ?AttractionPoint
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
