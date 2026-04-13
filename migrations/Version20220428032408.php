<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428032408 extends AbstractMigration
{

    public function up(Schema $schema): void
    {
        $this->addSql('UPDATE calculator SET payment_min=10, payment_max=90, default_payment=15');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
