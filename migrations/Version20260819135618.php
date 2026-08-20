<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260819135618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE knowledge_image (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, original_filename VARCHAR(255) DEFAULT NULL, mime_type VARCHAR(100) DEFAULT NULL, file_size INT DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE knowledge_article ADD featured_image_id INT DEFAULT NULL, DROP featured_image');
        $this->addSql('ALTER TABLE knowledge_article ADD CONSTRAINT FK_7D7D20E93569D950 FOREIGN KEY (featured_image_id) REFERENCES knowledge_image (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_7D7D20E93569D950 ON knowledge_article (featured_image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE knowledge_image');
        $this->addSql('ALTER TABLE knowledge_article DROP FOREIGN KEY FK_7D7D20E93569D950');
        $this->addSql('DROP INDEX IDX_7D7D20E93569D950 ON knowledge_article');
        $this->addSql('ALTER TABLE knowledge_article ADD featured_image VARCHAR(255) DEFAULT NULL, DROP featured_image_id');
    }
}
