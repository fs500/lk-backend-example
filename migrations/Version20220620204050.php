<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620204050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE yandex_yml_offer (id INT AUTO_INCREMENT NOT NULL, shop_id INT DEFAULT NULL, category_id INT DEFAULT NULL, object_id INT DEFAULT NULL, currency_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, param_conversion INT DEFAULT NULL, param_offer_type VARCHAR(255) DEFAULT NULL, vendor VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, param_builder_url VARCHAR(255) DEFAULT NULL, param_min_mortgage NUMERIC(4, 2) DEFAULT NULL, param_estate_type VARCHAR(255) DEFAULT NULL, param_estate_class LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', param_free_plan TINYINT(1) DEFAULT NULL, param_finishing LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', param_repair LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_69B45BE74D16C4DD (shop_id), INDEX IDX_69B45BE712469DE2 (category_id), UNIQUE INDEX UNIQ_69B45BE7232D562B (object_id), INDEX IDX_69B45BE738248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE yandex_yml_offer_yandex_yml_set (yandex_yml_offer_id INT NOT NULL, yandex_yml_set_id INT NOT NULL, INDEX IDX_7DFA30A65FAFF076 (yandex_yml_offer_id), INDEX IDX_7DFA30A6EFB405B4 (yandex_yml_set_id), PRIMARY KEY(yandex_yml_offer_id, yandex_yml_set_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE yandex_yml_offer ADD CONSTRAINT FK_69B45BE74D16C4DD FOREIGN KEY (shop_id) REFERENCES yandex_yml_shop (id)');
        $this->addSql('ALTER TABLE yandex_yml_offer ADD CONSTRAINT FK_69B45BE712469DE2 FOREIGN KEY (category_id) REFERENCES yandex_yml_category (id)');
        $this->addSql('ALTER TABLE yandex_yml_offer ADD CONSTRAINT FK_69B45BE7232D562B FOREIGN KEY (object_id) REFERENCES flat (id)');
        $this->addSql('ALTER TABLE yandex_yml_offer ADD CONSTRAINT FK_69B45BE738248176 FOREIGN KEY (currency_id) REFERENCES yandex_yml_currency (id)');
        $this->addSql('ALTER TABLE yandex_yml_offer_yandex_yml_set ADD CONSTRAINT FK_7DFA30A65FAFF076 FOREIGN KEY (yandex_yml_offer_id) REFERENCES yandex_yml_offer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE yandex_yml_offer_yandex_yml_set ADD CONSTRAINT FK_7DFA30A6EFB405B4 FOREIGN KEY (yandex_yml_set_id) REFERENCES yandex_yml_set (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yandex_yml_offer_yandex_yml_set DROP FOREIGN KEY FK_7DFA30A65FAFF076');
        $this->addSql('DROP TABLE yandex_yml_offer');
        $this->addSql('DROP TABLE yandex_yml_offer_yandex_yml_set');
    }
}
