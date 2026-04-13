<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621015541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yandex_yml_offer DROP FOREIGN KEY FK_69B45BE738248176');
        $this->addSql('DROP INDEX IDX_69B45BE738248176 ON yandex_yml_offer');
        $this->addSql('ALTER TABLE yandex_yml_offer DROP currency_id, DROP param_offer_type, DROP vendor, DROP param_builder_url, DROP param_min_mortgage, DROP param_estate_type, CHANGE param_repair param_repair VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yandex_yml_offer ADD currency_id INT DEFAULT NULL, ADD param_offer_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD vendor VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD param_builder_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD param_min_mortgage NUMERIC(4, 2) DEFAULT NULL, ADD param_estate_type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE param_repair param_repair LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE yandex_yml_offer ADD CONSTRAINT FK_69B45BE738248176 FOREIGN KEY (currency_id) REFERENCES yandex_yml_currency (id)');
        $this->addSql('CREATE INDEX IDX_69B45BE738248176 ON yandex_yml_offer (currency_id)');
    }
}
