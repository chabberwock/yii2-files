<?php

namespace chabberwock\files;

use Yii;

/**
 * files module definition class
 */
class Module extends \yii\base\Module
{
    public $uploadDir;
    public $expires = 3600;
    
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'chabberwock\files\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->uploadDir)) {
            $this->uploadDir = Yii::$app->basePath . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'temp';
        }
        if (empty($this->uploadDir)) {
            $this->uploadDir = '/uploads/temp/';
        }
        

        // custom initialization code goes here
    }
    
    public function createSession($config = null)
    {
        $session = Session::create($config);
        return $session;
    }
    
    /**
    * @param mixed $sessionId
    * @return Session
    */
    public function findSession($sessionId)
    {
        return Session::find($sessionId);
    }
    
}
