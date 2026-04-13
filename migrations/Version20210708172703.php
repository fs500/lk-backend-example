<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708172703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, deadline VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, map_image VARCHAR(255) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, qr_code_url LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE building_placement (id INT AUTO_INCREMENT NOT NULL, building_id INT DEFAULT NULL, header VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, sort INT DEFAULT NULL, INDEX IDX_B4B971734D2A7E12 (building_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE building_placement ADD CONSTRAINT FK_B4B971734D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE building_placement DROP FOREIGN KEY FK_B4B971734D2A7E12');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE building_placement');
    }
}
