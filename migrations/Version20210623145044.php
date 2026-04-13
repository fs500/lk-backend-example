<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623145044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE infrastructure (id INT AUTO_INCREMENT NOT NULL, header VARCHAR(255) DEFAULT NULL, sort INT DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE infrastructure_item (id INT AUTO_INCREMENT NOT NULL, infrastructure_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, address LONGTEXT DEFAULT NULL, sort INT DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, INDEX IDX_9949D2DB243E7A84 (infrastructure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_infrastructure (id INT AUTO_INCREMENT NOT NULL, header1 VARCHAR(255) DEFAULT NULL, header2 VARCHAR(255) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, scale INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE infrastructure_item ADD CONSTRAINT FK_9949D2DB243E7A84 FOREIGN KEY (infrastructure_id) REFERENCES infrastructure (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE infrastructure_item DROP FOREIGN KEY FK_9949D2DB243E7A84');
        $this->addSql('DROP TABLE infrastructure');
        $this->addSql('DROP TABLE infrastructure_item');
        $this->addSql('DROP TABLE page_infrastructure');
    }
}
