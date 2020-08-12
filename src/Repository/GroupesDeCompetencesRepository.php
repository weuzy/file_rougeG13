<?php

namespace App\Repository;

use App\Entity\GroupesDeCompetences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupesDeCompetences|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupesDeCompetences|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupesDeCompetences[]    findAll()
 * @method GroupesDeCompetences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupesDeCompetencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupesDeCompetences::class);
    }

    // /**
    //  * @return GroupesDeCompetences[] Returns an array of GroupesDeCompetences objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupesDeCompetences
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
