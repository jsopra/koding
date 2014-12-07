<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141207_051921_users_info
 *
 * Additional user fields
 */
class m141207_051921_users_info extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%user}}', 'first_name', Schema::TYPE_STRING . '(100) NOT NULL');
        $this->addColumn('{{%user}}', 'last_name', Schema::TYPE_STRING . '(100) NOT NULL');
        $this->addColumn('{{%user}}', 'photo', Schema::TYPE_STRING . '(255) NOT NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%users}}', 'first_name');
        $this->dropColumn('{{%users}}', 'last_name');
        $this->dropColumn('{{%users}}', 'photo');
    }
}
