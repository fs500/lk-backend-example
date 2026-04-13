<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708160227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE setting (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, header VARCHAR(255) NOT NULL, type VARCHAR(15) NOT NULL, value LONGTEXT DEFAULT NULL, note LONGTEXT DEFAULT NULL, file VARCHAR(50) DEFAULT NULL, uploaded DATE DEFAULT NULL, INDEX IDX_9F74B898FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, header VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE setting ADD CONSTRAINT FK_9F74B898FE54D947 FOREIGN KEY (group_id) REFERENCES setting_group (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE setting DROP FOREIGN KEY FK_9F74B898FE54D947');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE setting_group');
    }
}
