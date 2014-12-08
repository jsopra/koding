<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Add sharing_counter column to event table
 */
class m141208_030447_add_sharing_counter_to_events extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('event', 'sharing_counter', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');

        // Update current sharing count
        $this->execute('
            UPDATE event e
            SET sharing_counter = (
                SELECT COUNT(id)
                FROM shared_event
                WHERE event_id = e.id
            )
        ');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('event', 'sharing_counter');
    }
}
