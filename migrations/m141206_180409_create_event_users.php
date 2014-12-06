<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Creates event_user table
 */
class m141206_180409_create_event_users extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            'event_user',
            [
                'id' => Schema::TYPE_PK,
                'user_id' => Schema::TYPE_INTEGER . ' NOT NULL REFERENCES {{%user}} ON UPDATE CASCADE ON DELETE CASCADE',
                'event_id' => Schema::TYPE_INTEGER . ' NOT NULL REFERENCES {{%event}} ON UPDATE CASCADE ON DELETE CASCADE',
                'joined_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            ]
        );

        $this->createIndex(
            'uk_event_user',
            'event_user',
            ['user_id', 'event_id'],
            true
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('event_user');
    }
}
