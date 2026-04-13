<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622104139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE builder_advantage (id INT AUTO_INCREMENT NOT NULL, builder_id INT DEFAULT NULL, header VARCHAR(20) DEFAULT NULL, sub_header VARCHAR(20) DEFAULT NULL, sort INT DEFAULT NULL, INDEX IDX_600BCDB959F66E4 (builder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE builder_advantage ADD CONSTRAINT FK_600BCDB959F66E4 FOREIGN KEY (builder_id) REFERENCES builder (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE builder_advantage');
    }
}
