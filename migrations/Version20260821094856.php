<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260821094856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE knowledge_reference (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(500) NOT NULL, authors LONGTEXT DEFAULT NULL, journal VARCHAR(255) DEFAULT NULL, publication_year INT DEFAULT NULL, evidence_type VARCHAR(30) DEFAULT \'other\' NOT NULL, doi VARCHAR(255) DEFAULT NULL, external_url VARCHAR(1000) DEFAULT NULL, pdf_filename VARCHAR(255) DEFAULT NULL, summary LONGTEXT DEFAULT NULL, sort_order INT DEFAULT 0 NOT NULL, is_published TINYINT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, article_id INT NOT NULL, INDEX IDX_CE6EBF1F7294869C (article_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE knowledge_reference ADD CONSTRAINT FK_CE6EBF1F7294869C FOREIGN KEY (article_id) REFERENCES knowledge_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE knowledge_article ADD type VARCHAR(30) DEFAULT \'article\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE knowledge_reference DROP FOREIGN KEY FK_CE6EBF1F7294869C');
        $this->addSql('DROP TABLE knowledge_reference');
        $this->addSql('ALTER TABLE knowledge_article DROP type');
    }
}
