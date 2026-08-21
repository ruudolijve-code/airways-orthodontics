<?php

declare(strict_types=1);

namespace App\Knowledge\Entity;

use App\Knowledge\Enum\KnowledgeArticleType;
use App\Knowledge\Enum\KnowledgeAudience;
use App\Knowledge\Repository\KnowledgeArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KnowledgeArticleRepository::class)]
#[ORM\Table(name: 'knowledge_article')]
#[ORM\HasLifecycleCallbacks]
class KnowledgeArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?KnowledgeCategory $category = null;

    #[ORM\Column(
        length: 30,
        enumType: KnowledgeArticleType::class,
        options: ['default' => 'article'],
    )]
    private KnowledgeArticleType $type = KnowledgeArticleType::ARTICLE;

    #[ORM\Column(length: 180)]
    private string $title = '';

    #[ORM\Column(length: 200, unique: true)]
    private string $slug = '';

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $excerpt = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $intro = null;

    #[ORM\Column(type: 'text')]
    private string $content = '';

    #[ORM\Column(
        length: 20,
        enumType: KnowledgeAudience::class,
        options: ['default' => 'both'],
    )]
    private KnowledgeAudience $audience = KnowledgeAudience::BOTH;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $seoTitle = null;

    #[ORM\Column(length: 320, nullable: true)]
    private ?string $metaDescription = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?KnowledgeImage $featuredImage = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(options: ['default' => false])]
    private bool $isFeatured = false;

    #[ORM\Column(options: ['default' => 0])]
    private int $featuredOrder = 0;

    #[ORM\Column(nullable: true)]
    private ?int $readingTime = null;

    #[ORM\Column(options: ['default' => false])]
    private bool $isPublished = false;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $publishedAt = null;

    /**
     * @var Collection<int, KnowledgeReference>
     */
    #[ORM\OneToMany(
        mappedBy: 'article',
        targetEntity: KnowledgeReference::class,
        cascade: ['persist', 'remove'],
        orphanRemoval: true,
    )]
    #[ORM\OrderBy(['sortOrder' => 'ASC', 'publicationYear' => 'DESC'])]
    private Collection $references;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new \DateTimeImmutable();

        $this->createdAt = $now;
        $this->updatedAt = $now;
        $this->references = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?KnowledgeCategory
    {
        return $this->category;
    }

    public function setCategory(?KnowledgeCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getType(): KnowledgeArticleType
    {
        return $this->type;
    }

    public function setType(KnowledgeArticleType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function isMedicalDossier(): bool
    {
        return $this->type === KnowledgeArticleType::MEDICAL_DOSSIER;
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = trim($slug);

        return $this;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt !== null
            ? trim($excerpt)
            : null;

        return $this;
    }

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(?string $intro): self
    {
        $this->intro = $intro !== null
            ? trim($intro)
            : null;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAudience(): KnowledgeAudience
    {
        return $this->audience;
    }

    public function setAudience(KnowledgeAudience $audience): self
    {
        $this->audience = $audience;

        return $this;
    }

    public function getSeoTitle(): ?string
    {
        return $this->seoTitle;
    }

    public function setSeoTitle(?string $seoTitle): self
    {
        $this->seoTitle = $seoTitle !== null
            ? trim($seoTitle)
            : null;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription !== null
            ? trim($metaDescription)
            : null;

        return $this;
    }

    public function getFeaturedImage(): ?KnowledgeImage
    {
        return $this->featuredImage;
    }

    public function setFeaturedImage(?KnowledgeImage $featuredImage): self
    {
        $this->featuredImage = $featuredImage;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author !== null
            ? trim($author)
            : null;

        return $this;
    }

    public function isFeatured(): bool
    {
        return $this->isFeatured;
    }

    public function setIsFeatured(bool $isFeatured): self
    {
        $this->isFeatured = $isFeatured;

        return $this;
    }

    public function getFeaturedOrder(): int
    {
        return $this->featuredOrder;
    }

    public function setFeaturedOrder(int $featuredOrder): self
    {
        $this->featuredOrder = $featuredOrder;

        return $this;
    }

    public function getReadingTime(): ?int
    {
        return $this->readingTime;
    }

    public function setReadingTime(?int $readingTime): self
    {
        $this->readingTime = $readingTime;

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        if ($isPublished && $this->publishedAt === null) {
            $this->publishedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * @return Collection<int, KnowledgeReference>
     */
    public function getReferences(): Collection
    {
        return $this->references;
    }

    public function addReference(KnowledgeReference $reference): self
    {
        if (!$this->references->contains($reference)) {
            $this->references->add($reference);
            $reference->setArticle($this);
        }

        return $this;
    }

    public function removeReference(KnowledgeReference $reference): self
    {
        if ($this->references->removeElement($reference)) {
            if ($reference->getArticle() === $this) {
                $reference->setArticle(null);
            }
        }

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