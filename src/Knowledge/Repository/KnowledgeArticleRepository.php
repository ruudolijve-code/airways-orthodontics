<?php

declare(strict_types=1);

namespace App\Knowledge\Repository;

use App\Knowledge\Entity\KnowledgeArticle;
use App\Knowledge\Entity\KnowledgeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class KnowledgeArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KnowledgeArticle::class);
    }

    /**
     * @return list<KnowledgeArticle>
     */
    public function findPublishedByCategory(
        KnowledgeCategory $category,
    ): array {
        return $this->createQueryBuilder('article')
            ->andWhere('article.category = :category')
            ->andWhere('article.isPublished = :published')
            ->andWhere('article.publishedAt IS NULL OR article.publishedAt <= :now')
            ->setParameter('category', $category)
            ->setParameter('published', true)
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('article.publishedAt', 'DESC')
            ->addOrderBy('article.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findPublishedArticle(
        KnowledgeCategory $category,
        string $slug,
    ): ?KnowledgeArticle {
        return $this->createQueryBuilder('article')
            ->andWhere('article.category = :category')
            ->andWhere('article.slug = :slug')
            ->andWhere('article.isPublished = :published')
            ->andWhere(
                'article.publishedAt IS NULL OR article.publishedAt <= :now'
            )
            ->setParameter('category', $category)
            ->setParameter('slug', $slug)
            ->setParameter('published', true)
            ->setParameter('now', new \DateTimeImmutable())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findFeatured(int $limit = 6): array
    {
        return $this->createQueryBuilder('article')
            ->addSelect('category')
            ->innerJoin('article.category', 'category')
            ->andWhere('article.isPublished = :published')
            ->andWhere('article.isFeatured = :featured')
            ->andWhere('category.isPublished = :categoryPublished')
            ->andWhere(
                'article.publishedAt IS NULL OR article.publishedAt <= :now'
            )
            ->setParameter('published', true)
            ->setParameter('featured', true)
            ->setParameter('categoryPublished', true)
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('article.featuredOrder', 'ASC')
            ->addOrderBy('article.publishedAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}