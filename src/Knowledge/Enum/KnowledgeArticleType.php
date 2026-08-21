<?php

declare(strict_types=1);

namespace App\Knowledge\Enum;

enum KnowledgeArticleType: string
{
    case ARTICLE = 'article';
    case MEDICAL_DOSSIER = 'medical_dossier';

    public function label(): string
    {
        return match ($this) {
            self::ARTICLE => 'Artikel',
            self::MEDICAL_DOSSIER => 'Medisch dossier',
        };
    }
}