<?php

declare(strict_types=1);

namespace App\Knowledge\Controller;

use App\Knowledge\Repository\KnowledgeArticleRepository;
use App\Knowledge\Repository\KnowledgeCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class KnowledgeController extends AbstractController
{
    #[Route(
        '/kennisbank',
        name: 'knowledge_index',
        methods: ['GET'],
    )]

    public function index(
        KnowledgeCategoryRepository $categoryRepository,
        KnowledgeArticleRepository $articleRepository,
    ): Response {
        $categories = $categoryRepository->findPublished();

        $featuredArticles = $articleRepository->findFeatured();

        $medicalDossiers = $articleRepository->findPublishedMedicalDossiers();

        return $this->render('knowledge/index.html.twig', [
            'categories'       => $categories,
            'featuredArticles' => $featuredArticles,
            'medicalDossiers'  => $medicalDossiers,
        ]);
    }

    #[Route(
        '/kennisbank/{slug}',
        name: 'knowledge_category_show',
        methods: ['GET'],
    )]
    public function category(
        string $slug,
        KnowledgeCategoryRepository $categoryRepository,
        KnowledgeArticleRepository $articleRepository,
    ): Response {
        $category = $categoryRepository->findOneBy([
            'slug' => $slug,
            'isPublished' => true,
        ]);

        if ($category === null) {
            throw $this->createNotFoundException(
                'Deze kennisbankcategorie bestaat niet of is niet gepubliceerd.',
            );
        }

        return $this->render('knowledge/category.html.twig', [
            'category' => $category,
            'articles' => $articleRepository->findPublishedByCategory(
                $category,
            ),
        ]);
    }

    #[Route(
        '/kennisbank/{categorySlug}/{slug}',
        name: 'knowledge_article_show',
        methods: ['GET'],
    )]
    public function article(
        string $categorySlug,
        string $slug,
        KnowledgeCategoryRepository $categoryRepository,
        KnowledgeArticleRepository $articleRepository,
    ): Response {
        $category = $categoryRepository->findOneBy([
            'slug' => $categorySlug,
            'isPublished' => true,
        ]);

        if ($category === null) {
            throw $this->createNotFoundException(
                'Deze kennisbankcategorie bestaat niet of is niet gepubliceerd.',
            );
        }

        $article = $articleRepository->findPublishedArticle(
            $category,
            $slug,
        );

        if ($article === null) {
            throw $this->createNotFoundException(
                'Dit kennisbankartikel bestaat niet of is niet gepubliceerd.',
            );
        }

        return $this->render('knowledge/article.html.twig', [
            'category' => $category,
            'article' => $article,
        ]);
    }
}