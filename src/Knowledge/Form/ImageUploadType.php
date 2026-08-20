<?php

declare(strict_types=1);

namespace App\Knowledge\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

final class ImageUploadType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder->add('file', FileType::class, [
            'label' => 'Afbeelding',
            'mapped' => false,
            'required' => true,
            'constraints' => [
                new File([
                    'maxSize' => '8M',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ],
                ]),
            ],
        ]);
    }
}