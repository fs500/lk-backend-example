<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Services\SettingMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726205508 extends SettingMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $groupId = $this->addGroup('legal', 'Правовая информация');
        $this->addSettingByGroupId(
            $groupId,
            'text',
            'Текст',
            'text',
            'Информация, предоставленная на сайте, не является публичной офертой. Все цены действительны на {date} при условии единовременной оплаты. Элементы благоустройства, иллюстрации и описания дизайн-проектов квартир приведены для сведения, являются примером возможной организации жилого пространства. Представленные сведения носят исключительно информационный характер.',
            'Для вставки даты можно использовать специальный тег {date}, который будет заменяться на текущую дату.'
        );
    }

    public function down(Schema $schema): void
    {
        $this->removeGroup('legal');
    }
}
