<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Creates event table
 */
class m141206_152744_create_event extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(
            '{{%event}}',
            [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . ' NOT NULL',
                'hashtag' => Schema::TYPE_STRING . ' NOT NULL',
                'description' => Schema::TYPE_TEXT . ' NOT NULL',
                'occurred_on' => Schema::TYPE_DATE . ' NOT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%event}}');
    }
}
