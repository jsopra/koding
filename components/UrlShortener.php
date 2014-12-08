<?php

namespace app\components;

use Hpatoio\Bitly\Client;
use yii\base\Component;

/**
 * Class UrlShortener
 * @package app\components
 */
class UrlShortener extends Component
{
    
    /**
     * @var string
     */
    public $token;

    /**
     * @var string
     */
    protected $url = 'https://api-ssl.bitly.com/v3/shorten?';

    /**
     * @var Client
     */
    protected $api;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->api = new Client($this->token);
    }
    
    /**
     * @param string $url Url to shorten
     * @return null
     */
    public function shorten($url)
    {
        $params = [
            'access_token' => $this->token,
            'longUrl' => $url,
        ];
        $url = $this->url . http_build_query($params);
        $response = $this->api->get($url)->send();
        $result = $response->json();
        return isset($result['url']) ? $result['url'] : null;
    }
}
