<?php
namespace app\models\chart;

use yii\base\Model;

/**
 * Represent users who joined the event accross countries
 */
class EventMap extends Model
{
    /**
     * @var Event record used to find joiners data
     */
    public $event;

    /**
     * @return array containing <code>['country' => 'US', 'value' => 12345]</code>
     */
    public function getJoinedUsersByCountry()
    {
        $results = [];
        $query = $this->event->getUsers()
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
}
