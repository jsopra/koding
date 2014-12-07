<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141207_094816_user_address
 *
 * User address
 */
class m141207_094816_user_address extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%user}}', 'address', Schema::TYPE_TEXT . '(255) NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%user}}', 'address');
    }
}
