<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Services\SettingMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210708160252 extends SettingMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $groupId = $this->addGroup('scripts', 'Скрипты');

        $this->addSettingByGroupId(
            $groupId,
            'head',
            'Скрипты в секции HEAD',
            'script',
        );
        $this->addSettingByGroupId(
            $groupId,
            'bodyOpen',
            'Скрипты в после открывающегося тега BODY',
            'script',
        );
        $this->addSettingByGroupId(
            $groupId,
            'bodyClose',
            'Скрипты перед закрывающимся тегом BODY',
            'script',
        );

    }

    public function down(Schema $schema): void
    {
        $this->removeGroup('scripts');
    }
}
