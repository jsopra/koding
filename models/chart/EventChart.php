<?php
namespace app\models\chart;

use app\models\Event;
use app\models\Social;
use app\models\SharedEvent;
use yii\base\Model;

/**
 * Events statistics
 */
class EventChart extends Model
{
    /**
     * @var app\models\Event record used to find joiners data
     */
    public $event;

    /**
     * @var array cached top sharer countries
     * @see EventChart::getTopSharerCountries()
     */
    protected $topSharerCountriesCache;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!$this->event instanceof Event) {
            throw new \Exception('"event" attribute must be an Event instance.');
        }
    }

    /**
     * @return array containing chart series data
     */
    public function getSharingsBySocialNetwork()
    {
        $results = [
            Social::FACEBOOK => [
                'name' => 'Facebook',
                'color' => '#4c74c4',
                'y' => 0,
            ],
            Social::TWITTER => [
                'name' => 'Twitter',
                'color' => '#00aced',
                'y' => 0,
            ],
        ];

        $records = SharedEvent::getDb()
            ->createCommand(
                '
                    SELECT se.social, COUNT(se.user_id) AS sharings
                    FROM shared_event se
                    JOIN user u ON u.id = se.user_id
                    JOIN country c ON c.id = u.country_id
                    WHERE se.event_id = :event
                    GROUP BY se.social
                ',
                [':event' => $this->event->id]
            )
            ->queryAll()
        ;

        foreach ($records as &$record) {
            if ($record['social']) {
                $results[$record['social']]['y'] = (int) $record['sharings'];
            }
        }

        return array_values($results);
    }

    /**
     * @return array containing chart series and their data
     */
    public function getSeriesBySocialNetworkAndCountry()
    {
        $results = [
            Social::FACEBOOK => [
                'name' => 'Facebook',
                'color' => '#4c74c4',
                'data' => [],
            ],
            Social::TWITTER => [
                'name' => 'Twitter',
                'color' => '#00aced',
                'data' => [],
            ],
        ];

        foreach ($this->getTopSharerCountries() as $countryData) {
            $results[Social::FACEBOOK]['data'][] = (int) $countryData['facebook_sharings'];
            $results[Social::TWITTER]['data'][] = (int) $countryData['twitter_sharings'];
        }

        return array_values($results);
    }

    /**
     * @return array containing chart series and their data
     */
    public function getXAxisBySocialNetworkAndCountry()
    {
        $countries = $this->getTopSharerCountries();
        $countries = [];

        foreach ($this->getTopSharerCountries() as $countryData) {
            $countries[] = $countryData['name'];
        }

        return $countries;
    }

    /**
     * @return array countries with bigger number of sharings
     */
    public function getTopSharerCountries()
    {
        if (null === $this->topSharerCountriesCache) {
            $this->topSharerCountriesCache = SharedEvent::getDb()
                ->createCommand(
                    '
                        SELECT
                            c.id,
                            c.name,
                            COUNT(se.id) AS total_sharings,
                            SUM(CASE
                                WHEN social = ' . Social::TWITTER . ' THEN 1
                                ELSE 0
                            END) AS twitter_sharings,
                            SUM(CASE
                                WHEN social = ' . Social::FACEBOOK . ' THEN 1
                                ELSE 0
                            END) AS facebook_sharings
                        FROM shared_event se
                        JOIN user u ON u.id = se.user_id
                        JOIN country c ON c.id = u.country_id
                        WHERE se.event_id = :event
                        GROUP BY c.id, c.name
                        ORDER BY total_sharings DESC
                        LIMIT 5
                    ',
                    [':event' => $this->event->id]
                )
                ->queryAll()
            ;
        }
        return $this->topSharerCountriesCache;
    }

    /**
     * @return boolean if it has data to render for social networks chart
     */
    public function hasSocialNetworksData()
    {
        return SharedEvent::find()->where(['event_id' => $this->event->id])->count() > 0;
    }

    /**
     * @return boolean if it has data to render for social networks chart
     */
    public function hasTopCountriesData()
    {
        return SharedEvent::getDb()
            ->createCommand(
                '
                    SELECT COUNT(se.id) AS sharings
                    FROM shared_event se
                    JOIN user u ON u.id = se.user_id
                    JOIN country c ON c.id = u.country_id
                    WHERE se.event_id = :event
                ',
                [':event' => $this->event->id]
            )
            ->queryOne()['sharings'] > 0
        ;
    }
}
