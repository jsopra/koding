<?php

namespace app\models\sharer;

/**
 * Class SharerTrait
 * @package app\models\sharer
 */
trait SharerTrait
{
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
