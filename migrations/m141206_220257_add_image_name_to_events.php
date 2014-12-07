<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Adds image_name column to event table
 */
class m141206_220257_add_image_name_to_events extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn(
            'event',
            'image_name',
            Schema::TYPE_STRING
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('event', 'image_name');
    }
}
