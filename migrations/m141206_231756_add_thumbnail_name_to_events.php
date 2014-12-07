<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Adds thumbnail_name column to event table
 */
class m141206_231756_add_thumbnail_name_to_events extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn(
            'event',
            'thumbnail_name',
            Schema::TYPE_STRING
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('event', 'thumbnail_name');
    }
}
