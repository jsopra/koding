<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141207_163204_shared_events
 *
 * Log table which represents that Social message was sent from user's behalf.
 */
class m141207_163204_shared_events extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%shared_event}}', [
            'id' => Schema::TYPE_PK,
            'event_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'social' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'sent_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);
        $this->addForeignKey('event_id_fk', '{{%shared_event}}', 'event_id', '{{%event}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('user_id_fk', '{{%shared_event}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('event_user_social', '{{%shared_event}}', ['event_id', 'user_id', 'social'], true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%shared_event}}');
    }
}
