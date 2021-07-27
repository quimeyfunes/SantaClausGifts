<?php

namespace App\Repository;

use App\Entity\Gift;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GiftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gift::class);
    }

    public function getStatistics()
    {
        return $this->_em->createQueryBuilder()
            ->select('g.stockId as StockId, COUNT(g.uuid) as GiftCount, 
            COUNT(DISTINCT(r.countryCode)) as DifferentCountriesCount, AVG(g.price) as AveragePrice, 
            MAX(g.price) as MaxPrice, MIN(g.price) as MinPrice')
            ->from(Gift::class, 'g')
            ->innerJoin('g.receiver', 'r')
            ->groupBy('g.stockId')
            ->getQuery()
            ->getArrayResult();
    }
}