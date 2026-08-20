<?php

declare(strict_types=1);

namespace App\Knowledge\Repository;

use App\Knowledge\Entity\KnowledgeImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class KnowledgeImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KnowledgeImage::class);
    }
}