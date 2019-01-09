<?php

namespace App\Repository;

use App\Entity\Speler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Speler|null find($id, $lockMode = null, $lockVersion = null)
 * @method Speler|null findOneBy(array $criteria, array $orderBy = null)
 * @method Speler[]    findAll()
 * @method Speler[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpelerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Speler::class);
    }

    // /**
    //  * @return Speler[] Returns an array of Speler objects
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
    public function findOneBySomeField($value): ?Speler
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
