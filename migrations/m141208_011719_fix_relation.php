<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m141208_011719_fix_relation
 *
 * Fixes `event_user` relation, adds CASCADE CASCADE foreign key constraints
 */
class m141208_011719_fix_relation extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addForeignKey('event_user-user_id_fk', '{{%event_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('event_user-event_id_fk', '{{%event_user}}', 'event_id', '{{%event}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('event_user-user_id_fk', '{{%event_user}}');
        $this->dropForeignKey('event_user-event_id_fk', '{{%event_user}}');
    }
}
