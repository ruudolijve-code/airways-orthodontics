<?php

declare(strict_types=1);

namespace App\Knowledge\Enum;

enum KnowledgeAudience: string
{
    case PATIENT = 'patient';
    case PROFESSIONAL = 'professional';
    case BOTH = 'both';

    public function label(): string
    {
        return match ($this) {
            self::PATIENT => 'Patiënten',
            self::PROFESSIONAL => 'Verwijzers / Professionals',
            self::BOTH => 'Beiden',
        };
    }
}