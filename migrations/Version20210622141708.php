<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622141708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, header VARCHAR(255) DEFAULT NULL, sub_header VARCHAR(255) DEFAULT NULL, map_latitude DOUBLE PRECISION DEFAULT NULL, map_longitude DOUBLE PRECISION DEFAULT NULL, map_scale INT DEFAULT NULL, office_address LONGTEXT DEFAULT NULL, office_image VARCHAR(255) DEFAULT NULL, office_latitude DOUBLE PRECISION DEFAULT NULL, office_longitude DOUBLE PRECISION DEFAULT NULL, object_address LONGTEXT DEFAULT NULL, object_image VARCHAR(255) DEFAULT NULL, object_latitude DOUBLE PRECISION DEFAULT NULL, object_longitude DOUBLE PRECISION DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_commerce (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE page_commerce');
    }
}
