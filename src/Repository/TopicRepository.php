<?php

namespace App\Repository;

use App\Entity\Topic;
use App\Model\Searchbar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Topic>
 *
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

   /**
    * @return Topic[] Returns an array of Topic objects
    */
   public function findByUser($user, $limit): array
   {

    return $this->createQueryBuilder('t')
                ->join('t.user', 'u')
                ->andWhere('u.id = :userId')
                ->setParameter('userId', $user)
                ->orderBy('t.createdAt', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult()
    ;

   }

   /**
    * @return Topic[] Returns an array of Topic objects
    */
   public function findBySearch(Searchbar $searchbar, $limit): array
   {
       return $this->createQueryBuilder('t')
           ->andWhere('t.title LIKE :q')
           ->setParameter('q', "%{$searchbar->q}%")
           ->orderBy('t.createdAt', 'DESC')
           ->setMaxResults($limit)
           ->getQuery()
           ->getResult()
       ;
   }

//    /**
//     * @return Topic[] Returns an array of Topic objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Topic
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
