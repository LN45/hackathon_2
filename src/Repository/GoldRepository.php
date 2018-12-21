<?php

namespace App\Repository;

use App\Entity\Gold;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Gold|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gold|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gold[]    findAll()
 * @method Gold[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoldRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Gold::class);
    }

    // /**
    //  * @return Gold[] Returns an array of Gold objects
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
    public function findOneBySomeField($value): ?Gold
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
