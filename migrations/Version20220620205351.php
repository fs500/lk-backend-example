<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620205351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE yandex_yml_currency_yandex_yml_shop');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE yandex_yml_currency_yandex_yml_shop (yandex_yml_currency_id INT NOT NULL, yandex_yml_shop_id INT NOT NULL, INDEX IDX_71364AB392896416 (yandex_yml_shop_id), INDEX IDX_71364AB3A0A5EC81 (yandex_yml_currency_id), PRIMARY KEY(yandex_yml_currency_id, yandex_yml_shop_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE yandex_yml_currency_yandex_yml_shop ADD CONSTRAINT FK_71364AB392896416 FOREIGN KEY (yandex_yml_shop_id) REFERENCES yandex_yml_shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE yandex_yml_currency_yandex_yml_shop ADD CONSTRAINT FK_71364AB3A0A5EC81 FOREIGN KEY (yandex_yml_currency_id) REFERENCES yandex_yml_currency (id) ON DELETE CASCADE');
    }
}
