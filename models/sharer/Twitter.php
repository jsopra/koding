<?php

namespace app\models\sharer;

use yii\base\Object;
use yii\helpers\Json;

/**
 * Class Twitter
 * @package app\models\sharer
 */
class Twitter extends Object implements SharerInterface
{

    /**
     * @var \TwitterOAuth
     */
    protected $api;

    /**
     * @var array
     */
    protected $response;

    /**
     * @var string
     */
    private $_errorCode;

    /**
     * @var string
     */
    private $_errorMessage;
    
    /**
     * @param array $credentials Twitter Credentials
     */
    public function __construct($credentials)
    {
        $this->api = new \TwitterOAuth(
            $credentials['consumer_key'],
            $credentials['consumer_secret'],
            $credentials['token'],
            $credentials['token_secret']
        );
    }

    /**
     * @param array $details Post Details
     * @return boolean
     */
    public function post($details)
    {
        $this->_errorCode = $this->_errorMessage = $this->response = null;
        
        $this->response = (array) $this->api->post('statuses/update', [
            'status' => $details['message'],
        ]);
        
        if (isset($this->response['code'])) {
            if ($this->response['code'] == 200) {
                return true;
            } else {
                $this->_errorMessage = Json::encode($this->response['errors']);
                $this->_errorCode = $this->response['code'];
            }
        }
        return false;
    }

    /**
     * @return array response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
