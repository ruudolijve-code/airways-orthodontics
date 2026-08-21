<?php

declare(strict_types=1);

namespace App\Knowledge\Enum;

enum KnowledgeEvidenceType: string
{
    case SYSTEMATIC_REVIEW = 'systematic_review';
    case META_ANALYSIS = 'meta_analysis';
    case REVIEW = 'review';
    case RANDOMIZED_CONTROLLED_TRIAL = 'rct';
    case COHORT = 'cohort';
    case GUIDELINE = 'guideline';
    case CASE_CONTROL = 'case_control';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::SYSTEMATIC_REVIEW => 'Systematische review',
            self::META_ANALYSIS => 'Meta-analyse',
            self::REVIEW => 'Review',
            self::RANDOMIZED_CONTROLLED_TRIAL => 'Randomized controlled trial',
            self::COHORT => 'Cohortonderzoek',
            self::GUIDELINE => 'Richtlijn',
            self::CASE_CONTROL => 'Case-controlonderzoek',
            self::OTHER => 'Overig',
        };
    }
}