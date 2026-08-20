<?php

declare(strict_types=1);

namespace App\Knowledge\Service;

use App\Knowledge\Entity\KnowledgeImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final readonly class ImageUploader
{
    public function __construct(
        private string $knowledgeUploadDir,
        private SluggerInterface $slugger,
    ) {
    }

    public function upload(
        UploadedFile $file,
        ?string $alt = null,
    ): KnowledgeImage {

        $year = date('Y');
        $month = date('m');

        $directory = sprintf(
            '%s/%s/%s',
            $this->knowledgeUploadDir,
            $year,
            $month,
        );

        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $basename = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME,
        );

        $filename = sprintf(
            '%s-%s.%s',
            uniqid(),
            $this->slugger->slug($basename),
            $file->guessExtension() ?: 'jpg',
        );

        $file->move(
            $directory,
            $filename,
        );

        [$width, $height] = getimagesize(
            $directory.'/'.$filename,
        );

        $image = new KnowledgeImage();

        $image
            ->setFilename(sprintf(
                '%s/%s/%s',
                $year,
                $month,
                $filename,
            ))
            ->setOriginalFilename(
                $file->getClientOriginalName(),
            )
            ->setMimeType(
                $file->getMimeType(),
            )
            ->setFileSize(
                filesize($directory.'/'.$filename),
            )
            ->setWidth($width)
            ->setHeight($height)
            ->setAlt($alt);

        return $image;
    }
}