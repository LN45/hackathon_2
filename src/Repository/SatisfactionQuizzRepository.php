<?php

namespace App\Repository;

use App\Entity\SatisfactionQuizz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SatisfactionQuizz|null find($id, $lockMode = null, $lockVersion = null)
 * @method SatisfactionQuizz|null findOneBy(array $criteria, array $orderBy = null)
 * @method SatisfactionQuizz[]    findAll()
 * @method SatisfactionQuizz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SatisfactionQuizzRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SatisfactionQuizz::class);
    }

    // /**
    //  * @return SatisfactionQuizz[] Returns an array of SatisfactionQuizz objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SatisfactionQuizz
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
