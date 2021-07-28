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

    
    public function findFilterProperties($criteria = [])
    {
        $qb = $this->createQueryBuilder('p');

        // $qb->where() // SELECT * FROM ... WHERE ...=...
        // $qb->andWhere() // SELECT * FROM ... WHERE ...=.. AND ...=...
        // $qb->orWhere() // SELECT * FROM ... WHERE ...=.. OR ...=...

        if (array_key_exists("roomsMin", $criteria) && !empty($criteria["roomsMin"])) {
            $qb->andWhere($qb->expr()->gte('p.rooms', $criteria["roomsMin"]));
        }
        if (array_key_exists("roomsMax", $criteria) && !empty($criteria["roomsMax"])) {
            $qb->andWhere($qb->expr()->lte('p.rooms', $criteria["roomsMax"]));
        }
        if (array_key_exists("surfaceMin", $criteria) && !empty($criteria["surfaceMin"])) {
            $qb->andWhere($qb->expr()->gte('p.surface', $criteria["surfaceMin"]));
        }
        if (array_key_exists("surfaceMax", $criteria) && !empty($criteria["surfaceMax"])) {
            $qb->andWhere($qb->expr()->lte('p.surface', $criteria["surfaceMax"]));
        }
        if (array_key_exists("priceMin", $criteria) && !empty($criteria["priceMin"])) {
            $qb->andWhere($qb->expr()->gte('p.price', $criteria["priceMin"]));
        }
        if (array_key_exists("priceMax", $criteria) && !empty($criteria["priceMax"])) {
            $qb->andWhere($qb->expr()->lte('p.price', $criteria["priceMax"]));
        }
        if (array_key_exists("sort", $criteria) && !empty($criteria["sort"])) {
            if (array_key_exists("direction", $criteria) && !empty($criteria["direction"])) {
                $qb->orderBy($criteria["sort"], $criteria["direction"]);
            } else {
                $qb->orderBy($criteria["sort"], "ASC");
            }
        }
        return $qb->getQuery()->getResult();
    }
    
}
