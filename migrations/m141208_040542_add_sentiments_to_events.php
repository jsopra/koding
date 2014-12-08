<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Add sentiment and sentiment_confidence columns to event table
 */
class m141208_040542_add_sentiments_to_events extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('event', 'sentiment', Schema::TYPE_STRING);
        $this->addColumn('event', 'sentiment_confidence', Schema::TYPE_FLOAT);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('event', 'sentiment');
        $this->dropColumn('event', 'sentiment_confidence');
    }
}
