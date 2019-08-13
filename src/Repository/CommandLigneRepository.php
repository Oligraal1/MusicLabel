<?php

namespace App\Repository;

use App\Entity\CommandLigne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CommandLigne|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandLigne|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandLigne[]    findAll()
 * @method CommandLigne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandLigneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CommandLigne::class);
    }

    // /**
    //  * @return CommandLigne[] Returns an array of CommandLigne objects
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
    public function findOneBySomeField($value): ?CommandLigne
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
