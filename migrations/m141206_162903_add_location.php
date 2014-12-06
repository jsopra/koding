<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141206_162903_add_location
 *
 * Add location support (Country, Region, City)
 * Bind those location fields to User
 */
class m141206_162903_add_location extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->createTable('{{%country}}', [
            'id' => Schema::TYPE_PK,
            'code' => 'CHAR(2) NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->createIndex('code', '{{%country}}', 'code', true);
        $this->createIndex('name', '{{%country}}', 'name', true);

        $this->createTable('{{%region}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->createIndex('name', '{{%region}}', 'name', true);

        $this->createTable('{{%city}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->createIndex('name', '{{%city}}', 'name', true);

        $this->alterUser();
    }

    /**
     * Adds relation to User table
     */
    private function alterUser()
    {
        $this->addColumn('{{%user}}', 'country_id', Schema::TYPE_INTEGER . ' DEFAULT NULL AFTER `registered_via`');
        $this->addForeignKey('country_id_fk', '{{%user}}', 'country_id', '{{%country}}', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('{{%user}}', 'region_id', Schema::TYPE_INTEGER . ' DEFAULT NULL AFTER `country_id`');
        $this->addForeignKey('region_id_fk', '{{%user}}', 'region_id', '{{%region}}', 'id', 'CASCADE', 'CASCADE');

        $this->addColumn('{{%user}}', 'city_id', Schema::TYPE_INTEGER . ' DEFAULT NULL AFTER `region_id`');
        $this->addForeignKey('city_id_fk', '{{%user}}', 'city_id', '{{%city}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @return bool
     */
    public function down()
    {
        $this->dropForeignKey('country_id_fk', '{{%user}}');
        $this->dropForeignKey('region_id_fk', '{{%user}}');
        $this->dropForeignKey('city_id_fk', '{{%user}}');

        $this->dropTable('{{%country}}');
        $this->dropTable('{{%region}}');
        $this->dropTable('{{%city}}');
    }
}
