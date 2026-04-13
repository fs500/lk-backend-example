<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210826163351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts CHANGE office_latitude office_latitude NUMERIC(15, 6) DEFAULT NULL, CHANGE office_longitude office_longitude NUMERIC(15, 6) DEFAULT NULL, CHANGE object_latitude object_latitude NUMERIC(15, 6) DEFAULT NULL, CHANGE object_longitude object_longitude NUMERIC(15, 6) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts CHANGE office_latitude office_latitude DOUBLE PRECISION DEFAULT NULL, CHANGE office_longitude office_longitude DOUBLE PRECISION DEFAULT NULL, CHANGE object_latitude object_latitude DOUBLE PRECISION DEFAULT NULL, CHANGE object_longitude object_longitude DOUBLE PRECISION DEFAULT NULL');
    }
}
