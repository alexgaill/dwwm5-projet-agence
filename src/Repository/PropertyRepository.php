<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    public function findLast5()
    {
            // SELECT * FROM property
        return $this->createQueryBuilder('p')
            // WHERE sell = false
            ->andWhere("p.sell = false")
            // ORDER BY id DESC
            ->orderBy('p.id', 'DESC')
            // LIMIT 5
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    
    // public function findOneBySomeField($criteria): ?Property
    // {
    //     $qb =$this->createQueryBuilder('p');
    // }
    
}
