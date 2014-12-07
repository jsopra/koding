<?php
namespace app\models;

use yii\db\ActiveQuery;

/**
 * Scopes for Event model
 */
class EventQuery extends ActiveQuery
{
    /**
     * @return EventQuery filtered by future events (today included)
     */
    public function future()
    {
        return $this->where('occurred_on >= CURRENT_DATE()');
    }

    /**
     * @return EventQuery filtered by past events
     */
    public function past()
    {
        return $this->where('occurred_on < CURRENT_DATE()');
    }
}
