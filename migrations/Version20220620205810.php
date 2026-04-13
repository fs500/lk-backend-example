<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620205810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yandex_yml_category DROP FOREIGN KEY FK_A259D594D16C4DD');
        $this->addSql('DROP INDEX IDX_A259D594D16C4DD ON yandex_yml_category');
        $this->addSql('ALTER TABLE yandex_yml_category DROP shop_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yandex_yml_category ADD shop_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE yandex_yml_category ADD CONSTRAINT FK_A259D594D16C4DD FOREIGN KEY (shop_id) REFERENCES yandex_yml_shop (id)');
        $this->addSql('CREATE INDEX IDX_A259D594D16C4DD ON yandex_yml_category (shop_id)');
    }
}
