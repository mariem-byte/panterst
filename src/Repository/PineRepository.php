<?php

namespace App\Repository;

use App\Entity\Pine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pine>
 *
 * @method Pine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pine[]    findAll()
 * @method Pine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pine::class);
    }

//    /**
//     * @return Pine[] Returns an array of Pine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pine
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
