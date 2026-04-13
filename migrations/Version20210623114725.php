<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623114725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE flat (id INT AUTO_INCREMENT NOT NULL, floor_id INT DEFAULT NULL, status VARCHAR(10) DEFAULT NULL, number INT DEFAULT NULL, plan VARCHAR(50) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, rooms VARCHAR(2) DEFAULT NULL, area DOUBLE PRECISION DEFAULT NULL, rooms_area DOUBLE PRECISION DEFAULT NULL, kitchen_area DOUBLE PRECISION DEFAULT NULL, price INT DEFAULT NULL, price_m INT DEFAULT NULL, INDEX IDX_554AAA44854679E2 (floor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flat ADD CONSTRAINT FK_554AAA44854679E2 FOREIGN KEY (floor_id) REFERENCES floor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE flat');
    }
}
