<?php

namespace App\Repository;

use App\Entity\JobFunction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JobFunction|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobFunction|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobFunction[]    findAll()
 * @method JobFunction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobFunctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobFunction::class);
    }

    // /**
    //  * @return JobFunction[] Returns an array of JobFunction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JobFunction
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
