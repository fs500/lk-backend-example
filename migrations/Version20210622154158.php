<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622154158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE building_progress (id INT AUTO_INCREMENT NOT NULL, date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE building_progress_item (id INT AUTO_INCREMENT NOT NULL, progress_id INT DEFAULT NULL, photo VARCHAR(50) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, sort INT DEFAULT NULL, INDEX IDX_620E6D5843DB87C9 (progress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE building_progress_item ADD CONSTRAINT FK_620E6D5843DB87C9 FOREIGN KEY (progress_id) REFERENCES building_progress (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE building_progress_item DROP FOREIGN KEY FK_620E6D5843DB87C9');
        $this->addSql('DROP TABLE building_progress');
        $this->addSql('DROP TABLE building_progress_item');
    }
}
