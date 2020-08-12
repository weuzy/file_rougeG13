<?php

namespace App\Repository;

use App\Entity\Promo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Promo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promo[]    findAll()
 * @method Promo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromoRepository extends ServiceEntityRepository
{

    const ITEMS_PER_PAGE = 2;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promo::class);
    }

    // /**
    //  * @return Promo[] Returns an array of Promo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Promo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByArchive($value,$limit,$page)
    {
        $firstResult = ($page -1) * self::ITEMS_PER_PAGE;
        return $this->createQueryBuilder('u')
            ->andWhere('u.archive = :val')
            ->setParameter('val', $value)
            ->setFirstResult($firstResult)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
}
