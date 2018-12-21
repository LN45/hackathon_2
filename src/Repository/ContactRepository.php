<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }


    public function averageNotation(int $eventid)
    {
        $qb=$this->createQueryBuilder ('c')
            ->select('AVG(sq.satisfactionNote) as avgNote')
            ->join ('c.satisfactionQuizz','sq')
            ->where ('c.hasResponse = true')
            ->andWhere ('sq.event = :eventid')
            ->setParameter ('eventid', $eventid)
            ->getQuery ()
        ;
        return $qb->getOneOrNullResult ();

    }

    public function SumContactCreation(int $eventid)
    {
        $qb=$this->createQueryBuilder ('c')
            ->select('SUM(sq.contactNumber) as sumContact')
            ->join ('c.satisfactionQuizz','sq')
            ->where ('c.hasResponse = true')
            ->andWhere ('sq.event = :eventid')
            ->setParameter ('eventid', $eventid)
            ->getQuery ()
        ;
        return $qb->getOneOrNullResult ();

    }

    public function nbAnswer(int $eventid)
    {
        $qb=$this->createQueryBuilder ('c')
            ->select('COUNT(c.hasResponse) as nbAnswer')
            ->join ('c.satisfactionQuizz','sq')
            ->where ('c.hasResponse = true')
            ->andWhere ('sq.event = :eventid')
            ->setParameter ('eventid', $eventid)
            ->getQuery ()
        ;
        return $qb->getOneOrNullResult ();

    }

    public function countParticipants(int $eventid)
    {
        $qb=$this->createQueryBuilder ('c')
            ->select('COUNT(c.event) as countParticipant')
            ->join ('c.satisfactionQuizz','sq')
            ->Where ('sq.event = :eventid')
            ->setParameter ('eventid', $eventid)
            ->getQuery ()
        ;
        return $qb->getOneOrNullResult ();

    }


    public function countEventByPerson(string $email)
    {
        $qb=$this->createQueryBuilder ('c')
            ->select('COUNT(c.event) as nbEvent')
//            ->join ('c.satisfactionQuizz','sq')
            ->where ('c.email = :email')
            ->setParameter ('email', $email)
            ->getQuery ()
        ;
        return $qb->getOneOrNullResult ();

    }

    public function countNewContactByPerson(string $email)
    {
        $qb=$this->createQueryBuilder ('c')
            ->select('SUM(sq.contactNumber) as nbNewContact')
            ->join ('c.satisfactionQuizz','sq')
            ->where ('c.email = :email')
            ->setParameter ('email', $email)
            ->getQuery ()
        ;
        return $qb->getOneOrNullResult ();

    }


    public function countEventByCompany(int $id)
    {
        $qb=$this->createQueryBuilder ('c')
            ->select('COUNT(c.event) as nbEvent')
//            ->join ('c.satisfactionQuizz','sq')
            ->where ('c.company = :id')
            ->setParameter ('id', $id)
            ->getQuery ()
        ;
        return $qb->getOneOrNullResult ();
    }


    public function countNewContactByCompany(int $id)
    {
        $qb=$this->createQueryBuilder ('c')
            ->select('SUM(sq.contactNumber) as nbNewContact')
            ->join ('c.satisfactionQuizz','sq')
            ->where ('c.company = :id')
            ->setParameter ('id', $id)
            ->getQuery ()
        ;
        return $qb->getOneOrNullResult ();

    }


    // /**
    //  * @return Contact[] Returns an array of Contact objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
