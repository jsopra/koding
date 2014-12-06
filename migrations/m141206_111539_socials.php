<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141206_111539_socials
 */
class m141206_111539_socials extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%social}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'social' => Schema::TYPE_INTEGER . '(2) NOT NULL',
            'social_id' => Schema::TYPE_STRING . ' NOT NULL',
            'meta' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
        
        $this->addColumn('{{%user}}', 'registered_via', Schema::TYPE_INTEGER . ' AFTER `status`');
        $this->addForeignKey('fk_socials_users', '{{%social}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%social}}');
    }
}
