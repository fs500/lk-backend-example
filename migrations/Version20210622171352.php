<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622171352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F1C4663E4');
        $this->addSql('DROP INDEX IDX_36AC99F1C4663E4 ON link');
        $this->addSql('ALTER TABLE link ADD page VARCHAR(255) DEFAULT NULL, DROP page_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE link ADD page_id INT DEFAULT NULL, DROP page');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_36AC99F1C4663E4 ON link (page_id)');
    }
}
