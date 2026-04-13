<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Services\SettingMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414082023 extends SettingMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $groupId = $this->addGroup('common', 'Общие настройки');
        $this->addSettingByGroupId(
            $groupId,
            'priceActionText',
            'Текст для квартир по акции',
            'text',
            '',
            ''
        );
    }

    public function down(Schema $schema): void
    {
        $this->removeGroup('legal');
    }
}
