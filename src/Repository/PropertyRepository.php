<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @return Property[] Returns an array of Property objects
     */

    public function findByAddressCity($value)
    {



        $conn = $this->getEntityManager()->getConnection();

        $sql = '
                SELECT * FROM property p INNER JOIN address a
                ON p.address_id = a.id 
                WHERE a.city LIKE :val
                ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['val' => "%".$value."%"]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }


    /*
    public function findOneBySomeField($value): ?Property
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
