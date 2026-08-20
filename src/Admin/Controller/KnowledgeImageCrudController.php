<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Knowledge\Entity\KnowledgeImage;
use App\Knowledge\Service\KnowledgeImageManager;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

final class KnowledgeImageCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly KnowledgeImageManager $imageManager,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return KnowledgeImage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Afbeelding')
            ->setEntityLabelInPlural('Afbeeldingen')
            ->setPageTitle(Crud::PAGE_INDEX, 'Afbeeldingen')
            ->setPageTitle(Crud::PAGE_NEW, 'Nieuwe afbeelding')
            ->setPageTitle(Crud::PAGE_EDIT, 'Afbeelding bewerken')
            ->setSearchFields([
                'title',
                'alt',
                'caption',
                'filename',
                'originalFilename',
            ])
            ->setDefaultSort([
                'createdAt' => 'DESC',
            ]);
    }

    public function configureFields(string $pageName): iterable
    {
        /*
         * TAB: Afbeelding
         */
        yield FormField::addTab('Afbeelding')
            ->setIcon('fas fa-image');

        yield FormField::addFieldset('Upload');

        yield TextField::new(
            'uploadedFile',
            'Afbeelding',
        )
            ->setFormType(FileType::class)
            ->setFormTypeOptions([
                'required' => $pageName === Crud::PAGE_NEW,
                'constraints' => [
                    new File([
                        'maxSize' => '8M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Upload een JPG-, PNG- of WebP-afbeelding.',
                    ]),
                ],
            ])
            ->setHelp(
                $pageName === Crud::PAGE_NEW
                    ? 'Toegestaan: JPG, PNG en WebP. Maximale bestandsgrootte: 8 MB.'
                    : 'Laat dit veld leeg om de huidige afbeelding te behouden.',
            )
            ->onlyOnForms();

        /*
         * Preview.
         *
         * Dit veld verzorgt géén upload.
         * Uploaden gebeurt via uploadedFile + KnowledgeImageManager.
         */
        yield ImageField::new(
            'filename',
            'Preview',
        )
            ->setBasePath('/uploads/knowledge/images')
            ->onlyOnIndex();

        yield FormField::addFieldset('Beschrijving');

        yield TextField::new(
            'title',
            'Titel',
        )
            ->setHelp(
                'Interne titel waarmee de afbeelding eenvoudig terug te vinden is.',
            );

        yield TextField::new(
            'alt',
            'Alt-tekst',
        )
            ->setHelp(
                'Beschrijf kort wat op de afbeelding te zien is. Belangrijk voor toegankelijkheid en SEO.',
            );

        yield TextareaField::new(
            'caption',
            'Onderschrift',
        )
            ->setNumOfRows(4)
            ->setHelp(
                'Optioneel onderschrift dat onder de afbeelding kan worden weergegeven.',
            )
            ->hideOnIndex();

        /*
         * TAB: Bestandsinformatie
         */
        yield FormField::addTab('Bestandsinformatie')
            ->setIcon('fas fa-circle-info');

        yield FormField::addFieldset('Technische gegevens');

        yield ImageField::new(
            'filename',
            'Afbeelding',
        )
            ->setBasePath('/uploads/knowledge/images')
            ->hideWhenCreating()
            ->onlyWhenUpdating();

        yield TextField::new(
            'filename',
            'Bestandsnaam',
        )
            ->setDisabled()
            ->hideWhenCreating();

        yield TextField::new(
            'originalFilename',
            'Originele bestandsnaam',
        )
            ->setDisabled()
            ->hideWhenCreating();

        yield TextField::new(
            'mimeType',
            'Mime-type',
        )
            ->setDisabled()
            ->hideWhenCreating();

        yield IntegerField::new(
            'fileSize',
            'Bestandsgrootte (bytes)',
        )
            ->setDisabled()
            ->hideWhenCreating();

        yield IntegerField::new(
            'width',
            'Breedte (px)',
        )
            ->setDisabled()
            ->hideWhenCreating();

        yield IntegerField::new(
            'height',
            'Hoogte (px)',
        )
            ->setDisabled()
            ->hideWhenCreating();

        /*
         * TAB: Systeem
         */
        yield FormField::addTab('Systeem')
            ->setIcon('fas fa-gear');

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

    public function persistEntity(
        EntityManagerInterface $entityManager,
        $entityInstance,
    ): void {
        if (!$entityInstance instanceof KnowledgeImage) {
            parent::persistEntity($entityManager, $entityInstance);

            return;
        }

        $this->imageManager->save($entityInstance);
    }

    public function updateEntity(
        EntityManagerInterface $entityManager,
        $entityInstance,
    ): void {
        if (!$entityInstance instanceof KnowledgeImage) {
            parent::updateEntity($entityManager, $entityInstance);

            return;
        }

        $this->imageManager->save($entityInstance);
    }

    public function deleteEntity(
        EntityManagerInterface $entityManager,
        $entityInstance,
    ): void {
        if (!$entityInstance instanceof KnowledgeImage) {
            parent::deleteEntity($entityManager, $entityInstance);

            return;
        }

        $this->imageManager->delete($entityInstance);
    }
}