<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705095228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calculator ADD years_min INT DEFAULT NULL, ADD years_max INT DEFAULT NULL, DROP yars_min, DROP yars_max');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calculator ADD yars_min INT DEFAULT NULL, ADD yars_max INT DEFAULT NULL, DROP years_min, DROP years_max');
    }
}
