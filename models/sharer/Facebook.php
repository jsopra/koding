<?php

namespace app\models\sharer;

use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;
use yii\base\Object;

/**
 * Class Facebook
 * @package app\models\sharer
 */
class Facebook extends Object implements SharerInterface
{

    /**
     * @var FacebookSession
     */
    protected $session;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    private $_errorCode;

    /**
     * @var string
     */
    private $_errorMessage;

    /**
     * @var string
     */
    protected $response;
    
    /**
     * @param string $accessToken App access token
     * @param string $id facebook ID
     */
    public function __construct($accessToken, $id)
    {
        $this->id = $id;
        $this->session = new FacebookSession($accessToken);
        
    }

    /**
     * @inheritdoc
     */
    public function post($details)
    {
        $this->_errorCode = $this->response = $this->_errorMessage = null;
        try {
            $this->response = (new FacebookRequest($this->session, 'POST', '/' . $this->id . '/feed', [
                'link' => isset($details['link']) ? $details['link'] : null,
                'message' => $details['message'],
            ]))->execute()->getGraphObject();
            return true;
        } catch (FacebookRequestException $e) {
            $this->_errorCode = $e->getCode();
            $this->_errorMessage = $e->getMessage();
        }
        return false;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->_errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->_errorMessage;
    }
}
