<?php

namespace App\Repository;

use App\Entity\Tornooi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tornooi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tornooi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tornooi[]    findAll()
 * @method Tornooi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TornooiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tornooi::class);
    }

    // /**
    //  * @return Tornooi[] Returns an array of Tornooi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tornooi
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
