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
        $this->execute('DELETE E.* FROM `event_user` AS E LEFT JOIN `user` AS U ON E.user_id=U.id AND U.id IS NULL');
        $this->execute('DELETE EU.* FROM `event_user` AS EU LEFT JOIN `event` AS E ON EU.user_id=E.id AND E.id IS NULL');
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
