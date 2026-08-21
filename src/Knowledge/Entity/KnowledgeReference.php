<?php

declare(strict_types=1);

namespace App\Knowledge\Entity;

use App\Knowledge\Enum\KnowledgeEvidenceType;
use App\Knowledge\Repository\KnowledgeReferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KnowledgeReferenceRepository::class)]
#[ORM\Table(name: 'knowledge_reference')]
#[ORM\HasLifecycleCallbacks]
class KnowledgeReference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'references')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?KnowledgeArticle $article = null;

    #[ORM\Column(length: 500)]
    private string $title = '';

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $authors = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $journal = null;

    #[ORM\Column(nullable: true)]
    private ?int $publicationYear = null;

    #[ORM\Column(
        length: 30,
        enumType: KnowledgeEvidenceType::class,
        options: ['default' => 'other'],
    )]
    private KnowledgeEvidenceType $evidenceType = KnowledgeEvidenceType::OTHER;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $doi = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $externalUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdfFilename = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $summary = null;

    #[ORM\Column(options: ['default' => 0])]
    private int $sortOrder = 0;

    #[ORM\Column(options: ['default' => true])]
    private bool $isPublished = true;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new \DateTimeImmutable();

        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?KnowledgeArticle
    {
        return $this->article;
    }

    public function setArticle(?KnowledgeArticle $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = trim($title);

        return $this;
    }

    public function getAuthors(): ?string
    {
        return $this->authors;
    }

    public function setAuthors(?string $authors): self
    {
        $this->authors = $authors !== null
            ? trim($authors)
            : null;

        return $this;
    }

    public function getJournal(): ?string
    {
        return $this->journal;
    }

    public function setJournal(?string $journal): self
    {
        $this->journal = $journal !== null
            ? trim($journal)
            : null;

        return $this;
    }

    public function getPublicationYear(): ?int
    {
        return $this->publicationYear;
    }

    public function setPublicationYear(?int $publicationYear): self
    {
        $this->publicationYear = $publicationYear;

        return $this;
    }

    public function getEvidenceType(): KnowledgeEvidenceType
    {
        return $this->evidenceType;
    }

    public function setEvidenceType(KnowledgeEvidenceType $evidenceType): self
    {
        $this->evidenceType = $evidenceType;

        return $this;
    }

    public function getDoi(): ?string
    {
        return $this->doi;
    }

    public function setDoi(?string $doi): self
    {
        $this->doi = $doi !== null
            ? trim($doi)
            : null;

        return $this;
    }

    public function getExternalUrl(): ?string
    {
        return $this->externalUrl;
    }

    public function setExternalUrl(?string $externalUrl): self
    {
        $this->externalUrl = $externalUrl !== null
            ? trim($externalUrl)
            : null;

        return $this;
    }

    public function getPdfFilename(): ?string
    {
        return $this->pdfFilename;
    }

    public function setPdfFilename(?string $pdfFilename): self
    {
        $this->pdfFilename = $pdfFilename !== null
            ? trim($pdfFilename)
            : null;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary !== null
            ? trim($summary)
            : null;

        return $this;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function updateTimestamp(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function __toString(): string
    {
        return $this->title;
    }
}