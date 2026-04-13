<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707142145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts ADD office_route_id INT DEFAULT NULL, ADD object_route_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_33401573AC4AC839 FOREIGN KEY (office_route_id) REFERENCES link (id)');
        $this->addSql('ALTER TABLE contacts ADD CONSTRAINT FK_33401573E23A598E FOREIGN KEY (object_route_id) REFERENCES link (id)');
        $this->addSql('CREATE INDEX IDX_33401573AC4AC839 ON contacts (office_route_id)');
        $this->addSql('CREATE INDEX IDX_33401573E23A598E ON contacts (object_route_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_33401573AC4AC839');
        $this->addSql('ALTER TABLE contacts DROP FOREIGN KEY FK_33401573E23A598E');
        $this->addSql('DROP INDEX IDX_33401573AC4AC839 ON contacts');
        $this->addSql('DROP INDEX IDX_33401573E23A598E ON contacts');
        $this->addSql('ALTER TABLE contacts DROP office_route_id, DROP object_route_id');
    }
}
