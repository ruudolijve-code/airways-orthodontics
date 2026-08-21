<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Knowledge\Entity\KnowledgeArticle;
use App\Knowledge\Enum\KnowledgeArticleType;
use App\Knowledge\Enum\KnowledgeAudience;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class KnowledgeArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return KnowledgeArticle::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Artikel / dossier')
            ->setEntityLabelInPlural('Artikelen & dossiers')
            ->setPageTitle(Crud::PAGE_INDEX, 'Kennisbank')
            ->setPageTitle(Crud::PAGE_NEW, 'Nieuw artikel of dossier')
            ->setPageTitle(Crud::PAGE_EDIT, 'Artikel of dossier bewerken')
            ->setSearchFields([
                'title',
                'slug',
                'excerpt',
                'author',
            ])
            ->setDefaultSort([
                'publishedAt' => 'DESC',
                'title' => 'ASC',
            ]);
    }

    public function configureFields(string $pageName): iterable
    {
        /*
         * TAB: Artikel
         */
        yield FormField::addTab('Artikel')
            ->setIcon('fas fa-file-lines');

        yield FormField::addFieldset('Basis');

        yield ChoiceField::new(
            'type',
            'Type',
        )
            ->setChoices([
                KnowledgeArticleType::ARTICLE->label() => KnowledgeArticleType::ARTICLE,
                KnowledgeArticleType::MEDICAL_DOSSIER->label() => KnowledgeArticleType::MEDICAL_DOSSIER,
            ])
            ->setRequired(true)
            ->setColumns(6)
            ->setHelp(
                'Kies "Medisch dossier" voor verdiepende medische onderwerpen '
                .'waaraan wetenschappelijke publicaties worden gekoppeld.',
            );

        yield AssociationField::new(
            'category',
            'Categorie',
        )
            ->setRequired(true)
            ->setColumns(6);

        yield TextField::new(
            'title',
            'Titel',
        )
            ->setRequired(true)
            ->setColumns(12);

        yield SlugField::new(
            'slug',
            'Slug',
        )
            ->setTargetFieldName('title')
            ->setRequired(true)
            ->setColumns(12);

        yield ChoiceField::new(
            'audience',
            'Doelgroep',
        )
            ->setChoices([
                KnowledgeAudience::PATIENT->label() => KnowledgeAudience::PATIENT,
                KnowledgeAudience::PROFESSIONAL->label() => KnowledgeAudience::PROFESSIONAL,
                KnowledgeAudience::BOTH->label() => KnowledgeAudience::BOTH,
            ])
            ->setRequired(true)
            ->setColumns(6);

        /*
         * Inleiding
         */
        yield FormField::addFieldset('Inleiding');

        yield TextareaField::new(
            'excerpt',
            'Samenvatting',
        )
            ->setNumOfRows(3)
            ->setHelp(
                'Korte samenvatting voor overzichtspagina’s en uitgelichte artikelen.',
            )
            ->hideOnIndex();

        yield TextareaField::new(
            'intro',
            'Introductie',
        )
            ->setNumOfRows(5)
            ->setHelp(
                'Inleidende tekst die boven de hoofdtekst van het artikel of dossier wordt weergegeven.',
            )
            ->hideOnIndex();

        /*
         * Rich text artikel
         */
        yield FormField::addFieldset('Artikel');

        yield TextareaField::new(
            'content',
            'Artikeltekst',
        )
            ->setFormTypeOptions([
                'attr' => [
                    'data-controller' => 'ckeditor',
                    'rows' => 30,
                ],
            ])
            ->setHelp(
                'Gebruik koppen, alinea’s, lijsten en links om de inhoud duidelijk te structureren.',
            )
            ->setRequired(true)
            ->hideOnIndex();

        /*
         * TAB: Homepage
         */
        yield FormField::addTab('Homepage')
            ->setIcon('fas fa-star');

        yield FormField::addFieldset('Uitgelicht');

        yield BooleanField::new(
            'isFeatured',
            'Uitgelicht',
        )
            ->setHelp(
                'Toon dit artikel of dossier in het blok met uitgelichte content op de kennisbank.',
            );

        yield IntegerField::new(
            'featuredOrder',
            'Volgorde',
        )
            ->setHelp(
                'Lagere nummers verschijnen eerder. Gebruik bijvoorbeeld 10, 20, 30.',
            );

        /*
         * TAB: Media
         */
        yield FormField::addTab('Media')
            ->setIcon('fas fa-image');

        yield FormField::addFieldset('Hero-afbeelding');

        yield AssociationField::new(
            'featuredImage',
            'Hero-afbeelding',
        )
            ->setHelp(
                'Selecteer een afbeelding uit de mediabibliotheek.',
            )
            ->hideOnIndex();

        /*
         * TAB: Artikelinformatie
         */
        yield FormField::addTab('Artikelinformatie')
            ->setIcon('fas fa-user');

        yield FormField::addFieldset('Auteur en leestijd');

        yield TextField::new(
            'author',
            'Auteur',
        )
            ->hideOnIndex();

        yield IntegerField::new(
            'readingTime',
            'Leestijd (minuten)',
        )
            ->setHelp(
                'Geschatte leestijd van het artikel of dossier.',
            )
            ->hideOnIndex();

        /*
         * TAB: SEO
         */
        yield FormField::addTab('SEO')
            ->setIcon('fas fa-magnifying-glass');

        yield FormField::addFieldset('Zoekmachines');

        yield TextField::new(
            'seoTitle',
            'SEO-titel',
        )
            ->setHelp(
                'Laat leeg om automatisch de titel te gebruiken.',
            )
            ->hideOnIndex();

        yield TextareaField::new(
            'metaDescription',
            'Meta description',
        )
            ->setNumOfRows(3)
            ->setHelp(
                'Korte omschrijving voor zoekmachines. Richtwaarde: ongeveer 140–160 tekens.',
            )
            ->hideOnIndex();

        /*
         * TAB: Publicatie
         */
        yield FormField::addTab('Publicatie')
            ->setIcon('fas fa-globe');

        yield FormField::addFieldset('Status');

        yield BooleanField::new(
            'isPublished',
            'Gepubliceerd',
        );

        yield DateTimeField::new(
            'publishedAt',
            'Publicatiedatum',
        )
            ->setHelp(
                'Wordt bij eerste publicatie automatisch ingesteld wanneer het veld nog leeg is.',
            )
            ->hideOnIndex();

        /*
         * Systeeminformatie
         */
        yield FormField::addFieldset('Systeeminformatie');

        yield DateTimeField::new(
            'createdAt',
            'Aangemaakt',
        )
            ->hideOnForm();

        yield DateTimeField::new(
            'updatedAt',
            'Gewijzigd',
        )
            ->hideOnForm();
    }
}