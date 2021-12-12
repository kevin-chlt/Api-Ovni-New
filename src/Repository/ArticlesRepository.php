<?php

namespace App\Repository;

use App\Entity\Articles;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    /**
      * @return Articles[]
     */
    public function findArticleByCategory(Category $category) : array
    {
        return $this->createQueryBuilder('a')
            ->join('a.category', 'c')
            ->where('c = :category')
            ->setParameter('category', $category)
            ->orderBy('a.publishedAt', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }



    public function getAllId(): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.id')
            ->getQuery()
            ->getResult();
    }
}
