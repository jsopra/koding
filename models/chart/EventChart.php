<?php
namespace app\models\chart;

use app\models\Event;
use app\models\Social;
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
        return [
            [
                'name' => 'Facebook',
                'color' => '#4c74c4',
                'y' => rand(5000, 10000),
            ],
            [
                'name' => 'Twitter',
                'color' => '#00aced',
                'y' => rand(5000, 10000),
            ],
        ];
    }

    /**
     * @return array containing chart series and their data
     */
    public function getSeriesBySocialNetworkAndCountry()
    {
        return [
            [
                'name' => 'Facebook',
                'color' => '#4c74c4',
                'data' => [70000, 50000, 40000, 30000, 20000],
            ],
            [
                'name' => 'Twitter',
                'color' => '#00aced',
                'data' => [20000, 20000, 30000, 20000, 10000],
            ],
        ];
    }

    /**
     * @return array containing chart series and their data
     */
    public function getXAxisBySocialNetworkAndCountry()
    {
        return [
            'United States',
            'England',
            'Germany',
            'Australia',
            'Argentina',
        ];
    }
}
