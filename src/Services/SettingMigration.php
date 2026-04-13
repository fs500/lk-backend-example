<?php


namespace App\Services;


use Doctrine\DBAL\Exception;
use Doctrine\Migrations\AbstractMigration;

abstract class SettingMigration extends AbstractMigration
{

    protected function addGroup($name, $header)
    {
        $this->connection->executeQuery('INSERT INTO setting_group SET `header` = :header, `name` = :name', [
            'name' => $name,
            'header' => $header,
        ]);
        return $this->connection->lastInsertId();
    }

    protected function addSettingByGroupId($groupId, $name, $header, $type, $value = null, $note = null){
        $this->addSql('INSERT INTO setting SET group_id=:groupId, name=:name, header=:header, type=:type, value=:value, note=:note',[
            'groupId' => $groupId,
            'name' => $name,
            'header' => $header,
            'type' => $type,
            'value' => $value,
            'note' => $note
        ]);
    }

    protected function removeGroup($name){
        $groupId = $this->getGroupId($name);
        if(!is_null($groupId)){
            $this->addSql('DELETE FROM setting WHERE `group_id`= :groupId', [
                'groupId' => $groupId
            ]);
            $this->addSql('DELETE FROM setting_group WHERE `name`=:name', [
                'name' => $name
            ]);
        }
    }

    protected function removeSettingByGroupId($groupId, $name){
        $this->addSql('DELETE FROM setting WHERE `group_id`=:groupId AND name=:name', [
            'groupId' => $groupId,
            'name' => $name
        ]);
    }

    protected function getGroupId($name){
        try {
            $result = $this->connection->fetchAssociative('SELECT id FROM setting_group WHERE `name`= :name', ['name' => $name]);
        } catch (Exception $e) {
        }
        if(isset($result['id'])){
            return $result['id'];
        }
    }
}