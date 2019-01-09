<?php

namespace App\Repository;

use App\Entity\Wedstrijd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Wedstrijd|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wedstrijd|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wedstrijd[]    findAll()
 * @method Wedstrijd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WedstrijdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Wedstrijd::class);
    }

    // /**
    //  * @return Wedstrijd[] Returns an array of Wedstrijd objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wedstrijd
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
