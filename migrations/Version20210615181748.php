<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210615181748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, type VARCHAR(100) DEFAULT NULL, header VARCHAR(255) DEFAULT NULL, url LONGTEXT DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, popup TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_36AC99F1C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, header VARCHAR(255) DEFAULT NULL, text LONGTEXT DEFAULT NULL, image1 VARCHAR(50) DEFAULT NULL, image2 VARCHAR(50) DEFAULT NULL, image3 VARCHAR(50) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, sub_header1 VARCHAR(255) DEFAULT NULL, sub_header2 VARCHAR(255) DEFAULT NULL, sub_header3 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_image (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, image VARCHAR(50) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, header VARCHAR(255) DEFAULT NULL, text LONGTEXT DEFAULT NULL, INDEX IDX_A3BCFB89C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_slide (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, link_id INT DEFAULT NULL, live_broadcast_id INT DEFAULT NULL, image VARCHAR(50) DEFAULT NULL, upload_date DATETIME DEFAULT NULL, header VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, sort INT DEFAULT NULL, INDEX IDX_146E11B4C4663E4 (page_id), INDEX IDX_146E11B4ADA40271 (link_id), INDEX IDX_146E11B42EA1066A (live_broadcast_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page_image ADD CONSTRAINT FK_A3BCFB89C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page_slide ADD CONSTRAINT FK_146E11B4C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page_slide ADD CONSTRAINT FK_146E11B4ADA40271 FOREIGN KEY (link_id) REFERENCES link (id)');
        $this->addSql('ALTER TABLE page_slide ADD CONSTRAINT FK_146E11B42EA1066A FOREIGN KEY (live_broadcast_id) REFERENCES link (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_slide DROP FOREIGN KEY FK_146E11B4ADA40271');
        $this->addSql('ALTER TABLE page_slide DROP FOREIGN KEY FK_146E11B42EA1066A');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F1C4663E4');
        $this->addSql('ALTER TABLE page_image DROP FOREIGN KEY FK_A3BCFB89C4663E4');
        $this->addSql('ALTER TABLE page_slide DROP FOREIGN KEY FK_146E11B4C4663E4');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_image');
        $this->addSql('DROP TABLE page_slide');
    }
}
