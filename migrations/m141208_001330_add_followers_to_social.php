<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Add followers column to social table
 */
class m141208_001330_add_followers_to_social extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('social', 'followers', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('social', 'followers');
    }
}
