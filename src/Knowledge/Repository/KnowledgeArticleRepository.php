<?php

declare(strict_types=1);

namespace App\Knowledge\Repository;

use App\Knowledge\Entity\KnowledgeArticle;
use App\Knowledge\Entity\KnowledgeCategory;
use App\Knowledge\Enum\KnowledgeArticleType;
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

    public function findPublishedMedicalDossiers(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.type = :type')
            ->andWhere('a.isPublished = true')
            ->setParameter('type', KnowledgeArticleType::MEDICAL_DOSSIER)
            ->orderBy('a.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function searchPublished(string $query): array
    {
        $query = trim($query);

        if ($query === '') {
            return [];
        }

        return $this->createQueryBuilder('article')
            ->leftJoin('article.category', 'category')
            ->leftJoin(
                'article.references',
                'reference',
                'WITH',
                'reference.isPublished = true',
            )
            ->addSelect('category')
            ->addSelect('reference')
            ->andWhere('article.isPublished = true')
            ->andWhere(
                'LOWER(article.title) LIKE LOWER(:query)
                OR LOWER(article.slug) LIKE LOWER(:query)
                OR LOWER(article.excerpt) LIKE LOWER(:query)
                OR LOWER(article.intro) LIKE LOWER(:query)
                OR LOWER(article.content) LIKE LOWER(:query)
                OR LOWER(category.name) LIKE LOWER(:query)
                OR LOWER(reference.title) LIKE LOWER(:query)
                OR LOWER(reference.authors) LIKE LOWER(:query)
                OR LOWER(reference.journal) LIKE LOWER(:query)
                OR LOWER(reference.doi) LIKE LOWER(:query)
                OR LOWER(reference.summary) LIKE LOWER(:query)
                OR LOWER(reference.clinicalRelevance) LIKE LOWER(:query)'
            )
            ->setParameter(
                'query',
                '%'.mb_strtolower($query).'%',
            )
            ->distinct()
            ->orderBy('article.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}