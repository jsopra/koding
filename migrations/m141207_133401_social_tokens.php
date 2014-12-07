<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141207_133401_social_tokens
 *
 * Social access token field.
 */
class m141207_133401_social_tokens extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%social}}', 'token', Schema::TYPE_TEXT . ' NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%social}}', 'token');
    }
}
