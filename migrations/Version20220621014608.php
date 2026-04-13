<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621014608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yandex_yml_offer DROP FOREIGN KEY FK_69B45BE7232D562B');
        $this->addSql('DROP INDEX UNIQ_69B45BE7232D562B ON yandex_yml_offer');
        $this->addSql('ALTER TABLE yandex_yml_offer CHANGE object_id flat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE yandex_yml_offer ADD CONSTRAINT FK_69B45BE7D3331C94 FOREIGN KEY (flat_id) REFERENCES flat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_69B45BE7D3331C94 ON yandex_yml_offer (flat_id)');
        $this->addSql('ALTER TABLE yandex_yml_shop CHANGE description description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yandex_yml_offer DROP FOREIGN KEY FK_69B45BE7D3331C94');
        $this->addSql('DROP INDEX UNIQ_69B45BE7D3331C94 ON yandex_yml_offer');
        $this->addSql('ALTER TABLE yandex_yml_offer CHANGE flat_id object_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE yandex_yml_offer ADD CONSTRAINT FK_69B45BE7232D562B FOREIGN KEY (object_id) REFERENCES flat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_69B45BE7232D562B ON yandex_yml_offer (object_id)');
        $this->addSql('ALTER TABLE yandex_yml_shop CHANGE description description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
