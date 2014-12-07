<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Adds awareness_created_counter column to event table
 */
class m141206_172849_add_awareness_created_counter_to_events extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn(
            'event',
            'awareness_created_counter',
            Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('event', 'awareness_created_counter');
    }
}
