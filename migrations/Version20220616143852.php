<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616143852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE yandex_yml_category (id INT AUTO_INCREMENT NOT NULL, shop_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, header VARCHAR(255) DEFAULT NULL, INDEX IDX_A259D594D16C4DD (shop_id), UNIQUE INDEX UNIQ_A259D59727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE yandex_yml_category ADD CONSTRAINT FK_A259D594D16C4DD FOREIGN KEY (shop_id) REFERENCES yandex_yml_shop (id)');
        $this->addSql('ALTER TABLE yandex_yml_category ADD CONSTRAINT FK_A259D59727ACA70 FOREIGN KEY (parent_id) REFERENCES yandex_yml_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yandex_yml_category DROP FOREIGN KEY FK_A259D59727ACA70');
        $this->addSql('DROP TABLE yandex_yml_category');
    }
}
