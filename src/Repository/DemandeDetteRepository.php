<?php

namespace App\Repository;

use App\Entity\DemandeDette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeDette>
 *
 * @method DemandeDette|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeDette|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeDette[]    findAll()
 * @method DemandeDette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeDetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeDette::class);
    }

//    /**
//     * @return DemandeDette[] Returns an array of DemandeDette objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DemandeDette
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
