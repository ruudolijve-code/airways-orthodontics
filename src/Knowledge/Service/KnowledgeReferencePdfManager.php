<?php

declare(strict_types=1);

namespace App\Knowledge\Service;

use App\Knowledge\Entity\KnowledgeReference;
use Doctrine\ORM\EntityManagerInterface;

final readonly class KnowledgeReferencePdfManager
{
    public function __construct(
        private PdfUploader $pdfUploader,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(KnowledgeReference $reference): void
    {
        $uploadedFile = $reference->getUploadedPdf();

        if ($uploadedFile !== null) {
            $oldFilename = $reference->getPdfFilename();

            $newFilename = $this->pdfUploader->upload($uploadedFile);

            $reference->setPdfFilename($newFilename);

            if ($oldFilename !== null) {
                $this->pdfUploader->delete($oldFilename);
            }

            $reference->setUploadedPdf(null);
        }

        $this->entityManager->persist($reference);
        $this->entityManager->flush();
    }

    public function delete(KnowledgeReference $reference): void
    {
        $this->pdfUploader->delete(
            $reference->getPdfFilename(),
        );

        $this->entityManager->remove($reference);
        $this->entityManager->flush();
    }
}