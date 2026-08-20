<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Knowledge\Entity\KnowledgeCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class KnowledgeCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return KnowledgeCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Categorie')
            ->setEntityLabelInPlural('Categorieën')
            ->setPageTitle(Crud::PAGE_INDEX, 'Kennisbank categorieën')
            ->setPageTitle(Crud::PAGE_NEW, 'Categorie toevoegen')
            ->setPageTitle(Crud::PAGE_EDIT, 'Categorie bewerken')
            ->setDefaultSort([
                'sortOrder' => 'ASC',
            ])
            ->setPaginatorPageSize(50);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Naam')
            ->setColumns(6);

        yield SlugField::new('slug', 'Slug')
            ->setTargetFieldName('name')
            ->setColumns(6);

        yield TextareaField::new('description', 'Beschrijving')
            ->setColumns(12)
            ->hideOnIndex();

        yield IntegerField::new('sortOrder', 'Volgorde')
            ->setHelp('Lager nummer wordt eerder weergegeven.')
            ->setColumns(4);

        yield BooleanField::new('isPublished', 'Gepubliceerd')
            ->setColumns(4);

        yield DateTimeField::new('createdAt', 'Aangemaakt')
            ->hideOnForm();

        yield DateTimeField::new('updatedAt', 'Gewijzigd')
            ->hideOnForm();
    }
}