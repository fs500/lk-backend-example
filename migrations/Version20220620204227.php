<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620204227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yandex_yml_shop ADD param_conversion INT DEFAULT NULL, ADD param_offer_type VARCHAR(255) DEFAULT NULL, ADD vendor VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT NOT NULL, ADD param_builder_url VARCHAR(255) DEFAULT NULL, ADD param_min_mortgage NUMERIC(4, 2) DEFAULT NULL, ADD param_estate_type VARCHAR(255) DEFAULT NULL, ADD param_estate_class LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD param_address VARCHAR(255) DEFAULT NULL, ADD param_latitude NUMERIC(15, 6) DEFAULT NULL, ADD param_longitude NUMERIC(15, 6) DEFAULT NULL, ADD param_built_year INT DEFAULT NULL, ADD param_total_floor INT DEFAULT NULL, ADD param_subway_distance INT DEFAULT NULL, ADD param_subway_distance_unit VARCHAR(255) DEFAULT NULL, ADD param_parking_type LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD param_finishing LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD param_repair LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD param_site VARCHAR(255) DEFAULT NULL, ADD param_phone VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE yandex_yml_shop DROP param_conversion, DROP param_offer_type, DROP vendor, DROP description, DROP param_builder_url, DROP param_min_mortgage, DROP param_estate_type, DROP param_estate_class, DROP param_address, DROP param_latitude, DROP param_longitude, DROP param_built_year, DROP param_total_floor, DROP param_subway_distance, DROP param_subway_distance_unit, DROP param_parking_type, DROP param_finishing, DROP param_repair, DROP param_site, DROP param_phone');
    }
}
