<?php

declare(strict_types=1);

namespace App\Knowledge\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final readonly class PdfUploader
{
    public function __construct(
        private string $knowledgeReferenceUploadDir,
        private SluggerInterface $slugger,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        $year = date('Y');
        $month = date('m');

        $directory = sprintf(
            '%s/%s/%s',
            $this->knowledgeReferenceUploadDir,
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
            '%s-%s.pdf',
            uniqid(),
            $this->slugger->slug($basename),
        );

        $file->move(
            $directory,
            $filename,
        );

        return sprintf(
            '%s/%s/%s',
            $year,
            $month,
            $filename,
        );
    }

    public function delete(?string $filename): void
    {
        if ($filename === null || $filename === '') {
            return;
        }

        $path = sprintf(
            '%s/%s',
            $this->knowledgeReferenceUploadDir,
            $filename,
        );

        if (is_file($path)) {
            unlink($path);
        }
    }
}