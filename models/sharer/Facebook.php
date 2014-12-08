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
    use SharerTrait;
    
    /**
     * @var FacebookSession
     */
    protected $session;

    /**
     * @var string
     */
    protected $id;
    
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
}
