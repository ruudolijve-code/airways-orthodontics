<?php

declare(strict_types=1);

namespace App\Knowledge\Repository;

use App\Knowledge\Entity\KnowledgeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class KnowledgeCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KnowledgeCategory::class);
    }

    /**
     * @return list<KnowledgeCategory>
     */
    public function findPublished(): array
    {
        return $this->createQueryBuilder('category')
            ->andWhere('category.isPublished = :published')
            ->setParameter('published', true)
            ->orderBy('category.sortOrder', 'ASC')
            ->addOrderBy('category.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}