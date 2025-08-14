<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Serie>
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findSeriesCustum(float $popularity, float $vote): array
    {

        return $this->createQueryBuilder('s')
            ->andWhere('s.popularity > :popularity AND s.firstAirDate > :date')
            ->andWhere('s.vote > :vote')
            ->orderBy('s.popularity', 'DESC')
            ->addOrderBy('s.firstAirDate', 'DESC')
            ->setParameter('popularity', $popularity)
            ->setParameter('vote', $vote)
            ->setParameter('date', new \DateTime('-5 years'))
            ->setFirstResult(0)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();


    }






//    /**
//     * @return Serie[] Returns an array of Serie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Serie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
