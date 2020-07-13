<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getQueryAllActive()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.active = :val')
            ->setParameter('val', 1)
            ->orderBy('a.date_add', 'ASC')
            ->getQuery()
            ;
    }

    /**
     * @return bool|int|mixed|string
     */
    public function getCountAllActive()
    {
        try {
            return $this->createQueryBuilder('a')
                ->select('COUNT(a.id)')
                ->andWhere('a.active = :val')
                ->setParameter('val', 1)
                ->orderBy('a.date_add', 'ASC')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return false;
        }
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
