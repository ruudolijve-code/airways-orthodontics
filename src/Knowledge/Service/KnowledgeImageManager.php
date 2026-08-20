<?php

declare(strict_types=1);

namespace App\Knowledge\Service;

use App\Knowledge\Entity\KnowledgeImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final readonly class KnowledgeImageManager
{
    public function __construct(
        private ImageUploader $imageUploader,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Verwerkt een upload en vult automatisch alle metadata.
     */
    public function handleUpload(KnowledgeImage $image): void
    {
        $uploadedFile = $image->getUploadedFile();

        if (!$uploadedFile instanceof UploadedFile) {
            return;
        }

        /*
         * Bij vervangen eerst het oude bestand verwijderen.
         */
        if ($image->getFilename() !== '') {
            $this->deletePhysicalFile($image);
        }

        $uploadedImage = $this->imageUploader->upload(
            $uploadedFile,
            $image->getAlt(),
        );

        $image
            ->setFilename($uploadedImage->getFilename())
            ->setOriginalFilename($uploadedImage->getOriginalFilename())
            ->setMimeType($uploadedImage->getMimeType())
            ->setFileSize($uploadedImage->getFileSize())
            ->setWidth($uploadedImage->getWidth())
            ->setHeight($uploadedImage->getHeight());

        $image->setUploadedFile(null);
    }

    /**
     * Slaat de entity op.
     */
    public function save(KnowledgeImage $image): void
    {
        $this->handleUpload($image);

        $this->entityManager->persist($image);
        $this->entityManager->flush();
    }

    /**
     * Verwijdert afbeelding én entity.
     */
    public function delete(KnowledgeImage $image): void
    {
        $this->deletePhysicalFile($image);

        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    /**
     * Verwijdert alleen het fysieke bestand.
     */
    private function deletePhysicalFile(KnowledgeImage $image): void
    {
        if ($image->getFilename() === '') {
            return;
        }

        $path = sprintf(
            '%s/public/uploads/knowledge/images/%s',
            dirname(__DIR__, 3),
            $image->getFilename(),
        );

        if (is_file($path)) {
            @unlink($path);
        }
    }
}