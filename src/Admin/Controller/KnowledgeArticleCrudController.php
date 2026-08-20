<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Knowledge\Entity\KnowledgeArticle;
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
use FOS\CKEditorBundle\Form\Type\CKEditorType;

final class KnowledgeArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return KnowledgeArticle::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Artikel')
            ->setEntityLabelInPlural('Artikelen')
            ->setPageTitle(Crud::PAGE_INDEX, 'Kennisbank')
            ->setPageTitle(Crud::PAGE_NEW, 'Nieuw artikel')
            ->setPageTitle(Crud::PAGE_EDIT, 'Artikel bewerken')
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

        yield AssociationField::new(
            'category',
            'Categorie',
        )
            ->setRequired(true);

        yield TextField::new(
            'title',
            'Titel',
        )
            ->setRequired(true);

        yield SlugField::new(
            'slug',
            'Slug',
        )
            ->setTargetFieldName('title')
            ->setRequired(true);

        yield ChoiceField::new(
            'audience',
            'Doelgroep',
        )
            ->setChoices([
                KnowledgeAudience::PATIENT->label() => KnowledgeAudience::PATIENT,
                KnowledgeAudience::PROFESSIONAL->label() => KnowledgeAudience::PROFESSIONAL,
                KnowledgeAudience::BOTH->label() => KnowledgeAudience::BOTH,
            ])
            ->setRequired(true);

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
                'Inleidende tekst die boven de hoofdtekst van het artikel wordt weergegeven.',
            )
            ->hideOnIndex();

        /*
         * Rich text artikel
         */
        yield FormField::addFieldset('Artikel');

        yield TextareaField::new(
            'content',
            'Artikel',
        )
            ->setFormTypeOptions([
                'attr' => [
                    'data-controller' => 'ckeditor',
                    'rows' => 30,
                ],
            ])
            ->setHelp(
                'Gebruik koppen, alinea’s, lijsten en links om het artikel duidelijk te structureren.',
            )
            ->setRequired(true)
            ->hideOnIndex();
        
        /*
         * TAB: Homepage
         */
        yield FormField::addTab('Homepage')
            ->setIcon('fas fa-star');

        yield FormField::addFieldset('Uitgelicht artikel');

        yield BooleanField::new(
            'isFeatured',
            'Uitgelicht',
        )
            ->setHelp(
                'Toon dit artikel in het blok met uitgelichte artikelen op de kennisbank.',
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
                'Geschatte leestijd van het artikel.',
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
                'Laat leeg om automatisch de artikeltitel te gebruiken.',
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