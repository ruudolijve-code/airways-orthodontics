<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260819133232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE knowledge_article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(180) NOT NULL, slug VARCHAR(200) NOT NULL, excerpt LONGTEXT DEFAULT NULL, intro LONGTEXT DEFAULT NULL, content LONGTEXT NOT NULL, audience VARCHAR(20) DEFAULT \'both\' NOT NULL, seo_title VARCHAR(180) DEFAULT NULL, meta_description VARCHAR(320) DEFAULT NULL, featured_image VARCHAR(255) DEFAULT NULL, author VARCHAR(150) DEFAULT NULL, is_featured TINYINT DEFAULT 0 NOT NULL, featured_order INT DEFAULT 0 NOT NULL, reading_time INT DEFAULT NULL, is_published TINYINT DEFAULT 0 NOT NULL, published_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, category_id INT NOT NULL, UNIQUE INDEX UNIQ_7D7D20E9989D9B62 (slug), INDEX IDX_7D7D20E912469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE knowledge_article ADD CONSTRAINT FK_7D7D20E912469DE2 FOREIGN KEY (category_id) REFERENCES knowledge_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE knowledge_article DROP FOREIGN KEY FK_7D7D20E912469DE2');
        $this->addSql('DROP TABLE knowledge_article');
    }
}
