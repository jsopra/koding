<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141206_224013_deprecate_region
 *
 * Deprecate Unneeded Region table and all it's relations
 */
class m141206_224013_deprecate_region extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropForeignKey('region_id_fk', '{{%user}}');
        $this->dropColumn('{{%user}}', 'region_id');
        $this->dropTable('{{%region}}');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('{{%region}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        $this->createIndex('name', '{{%region}}', 'name', true);
        $this->addColumn('{{%user}}', 'region_id', Schema::TYPE_INTEGER . ' DEFAULT NULL AFTER `country_id`');
        $this->addForeignKey('region_id_fk', '{{%user}}', 'region_id', '{{%region}}', 'id', 'CASCADE', 'CASCADE');
    }
}
