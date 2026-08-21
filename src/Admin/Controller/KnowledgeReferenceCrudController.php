<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Knowledge\Entity\KnowledgeReference;
use App\Knowledge\Enum\KnowledgeEvidenceType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

final class KnowledgeReferenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return KnowledgeReference::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Wetenschappelijke publicatie')
            ->setEntityLabelInPlural('Wetenschappelijke publicaties')
            ->setPageTitle(
                Crud::PAGE_INDEX,
                'Wetenschappelijke publicaties',
            )
            ->setPageTitle(
                Crud::PAGE_NEW,
                'Wetenschappelijke publicatie toevoegen',
            )
            ->setPageTitle(
                Crud::PAGE_EDIT,
                static fn (KnowledgeReference $reference): string =>
                    'Publicatie bewerken: '.$reference->getTitle(),
            )
            ->setDefaultSort([
                'publicationYear' => 'DESC',
                'sortOrder' => 'ASC',
            ])
            ->setSearchFields([
                'title',
                'authors',
                'journal',
                'doi',
                'summary',
                'clinicalRelevance',
                'limitations',
            ])
            ->setPaginatorPageSize(30);
    }

    public function configureFields(string $pageName): iterable
    {
        /*
         * Bibliografische gegevens
         */
        yield FormField::addFieldset('Bibliografische gegevens');

        yield AssociationField::new('article', 'Medisch dossier / artikel')
            ->setRequired(true)
            ->setColumns(12)
            ->setHelp(
                'Selecteer het medische dossier of kennisbankartikel '
                .'waar deze wetenschappelijke publicatie bij hoort.',
            );

        yield TextField::new('title', 'Titel')
            ->setRequired(true)
            ->setColumns(12);

        yield TextareaField::new('authors', 'Auteurs')
            ->setRequired(false)
            ->setColumns(12)
            ->setHelp(
                'Bijvoorbeeld: Tanellari O, Alushi A, Ghanim S, et al.',
            )
            ->hideOnIndex();

        yield TextField::new('journal', 'Tijdschrift')
            ->setRequired(false)
            ->setColumns(6);

        yield IntegerField::new('publicationYear', 'Publicatiejaar')
            ->setRequired(false)
            ->setColumns(3);

        yield ChoiceField::new('evidenceType', 'Type onderzoek')
            ->setChoices(KnowledgeEvidenceType::choices())
            ->setRequired(true)
            ->setColumns(3);

        /*
         * Bron en publicatie
         */
        yield FormField::addFieldset('Bron en publicatie');

        yield TextField::new('doi', 'DOI')
            ->setRequired(false)
            ->setColumns(6)
            ->setHelp(
                'Bijvoorbeeld: 10.3390/jcm14061963',
            );

        yield UrlField::new('externalUrl', 'Link naar publicatie')
            ->setRequired(false)
            ->setColumns(6)
            ->setHelp(
                'Link naar PubMed, DOI, uitgever of open-access publicatie.',
            );

        yield TextField::new('license', 'Licentie')
            ->setRequired(false)
            ->setColumns(6)
            ->setHelp(
                'Bijvoorbeeld: CC BY 4.0. '
                .'Gebruik dit om vast te leggen onder welke voorwaarden '
                .'de publicatie of PDF mag worden aangeboden.',
            );

        yield TextField::new('pdfFilename', 'PDF-bestand')
            ->setRequired(false)
            ->setColumns(6)
            ->setHelp(
                'De echte PDF-upload voegen we in de volgende stap toe. '
                .'Dit veld bevat uiteindelijk alleen de opgeslagen bestandsnaam.',
            )
            ->hideOnIndex();

        /*
         * Redactionele samenvatting
         */
        yield FormField::addFieldset('Samenvatting');

        yield TextareaField::new('summary', 'Nederlandse samenvatting')
            ->setRequired(false)
            ->setColumns(12)
            ->setHelp(
                'Vat de studie kort en neutraal samen. Beschrijf bij voorkeur '
                .'de onderzoeksvraag, populatie, methode en belangrijkste bevindingen.',
            )
            ->hideOnIndex();

        /*
         * Klinische betekenis
         */
        yield FormField::addFieldset('Klinische relevantie');

        yield TextareaField::new(
            'clinicalRelevance',
            'Klinische relevantie voor verwijzers',
        )
            ->setRequired(false)
            ->setColumns(12)
            ->setHelp(
                'Waarom is deze studie relevant voor bijvoorbeeld '
                .'huisartsen, KNO-artsen, orthodontisten of kaakchirurgen?',
            )
            ->hideOnIndex();

        /*
         * Kritische duiding
         */
        yield FormField::addFieldset('Beperkingen');

        yield TextareaField::new('limitations', 'Beperkingen van de studie')
            ->setRequired(false)
            ->setColumns(12)
            ->setHelp(
                'Noteer relevante beperkingen zoals steekproefgrootte, '
                .'onderzoeksopzet, selectiebias, beeldvorming of generaliseerbaarheid.',
            )
            ->hideOnIndex();

        /*
         * Publicatie-instellingen
         */
        yield FormField::addFieldset('Publicatie-instellingen');

        yield IntegerField::new('sortOrder', 'Volgorde')
            ->setColumns(3)
            ->setHelp(
                'Lager nummer wordt eerder getoond binnen het medische dossier.',
            );

        yield BooleanField::new('isPublished', 'Gepubliceerd')
            ->setColumns(3);

        yield DateTimeField::new('createdAt', 'Aangemaakt')
            ->hideOnForm();

        yield DateTimeField::new('updatedAt', 'Gewijzigd')
            ->hideOnForm();
    }
}