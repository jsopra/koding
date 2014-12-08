<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141207_230405_event_short_url
 *
 * Add short_url for event.
 */
class m141207_230405_event_short_url extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%event}}', 'short_url', Schema::TYPE_STRING . '(100) NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%event}}', 'short_url');
    }
}
