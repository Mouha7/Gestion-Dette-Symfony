<?php

namespace App\Repository;

use App\Entity\DemandeArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeArticle>
 *
 * @method DemandeArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeArticle[]    findAll()
 * @method DemandeArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeArticle::class);
    }

//    /**
//     * @return DemandeArticle[] Returns an array of DemandeArticle objects
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

//    public function findOneBySomeField($value): ?DemandeArticle
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
