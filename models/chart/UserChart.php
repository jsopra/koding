<?php
namespace app\models\chart;

use app\models\User;
use yii\base\Model;

/**
 * Represent users who joined the event accross countries
 */
class UserChart extends Model
{
    /**
     * @var app\models\Event record used to find joiners data
     */
    public $event;

    /**
     * @return array containing <code>['country' => 'US', 'value' => 12345]</code>
     */
    public function getJoinedUsersByCountry()
    {
        $results = [];
        $query = $this->getUsersQuery()
            ->with('country')
            ->select(['id', 'country_id']);

        // Paginate through records so that it doesn't explodes memory
        foreach ($query->batch(100) as $joinedUsers) {
            foreach ($joinedUsers as $user) {
                if (!$user->country) {
                    continue;
                }
                if (!isset($results[$user->country->code])) {
                    $results[$user->country->code] = [
                        'country' => $user->country->code,
                        'value' => 0,
                    ];
                }
                $results[$user->country->code]['value']++;
            }
        }

        return array_values($results);
    }

    /**
     * @return yii\db\ActiveQuery users query
     */
    protected function getUsersQuery()
    {
        if ($this->event) {
            return $this->event->getUsers();
        } else {
            return User::find();
        }
    }
}
