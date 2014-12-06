<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Adds joined_users_counter column to event table
 */
class m141206_172917_add_joined_users_counter_to_events extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn(
            'event',
            'joined_users_counter',
            Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('event', 'joined_users_counter');
    }
}
