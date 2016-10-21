<?php
namespace chabberwock\files;

use dosamigos\fileupload\FileUpload as BaseWidget;
use yii\helpers\Html;
use Yii;

class FileUpload extends BaseWidget
{
    public $sessionId;
    public $viewUploadButton = '@chabberwock/files/views/uploadButton';
    public $meta = array();
    
    public function init()
    {
        if (!isset($this->sessionId)) {
            $session = Module::getInstance()->createSession($this->meta);
            $this->sessionId = $session->id;
        }
        if ($this->model instanceof \yii\base\Model) {
            $this->model->{$this->attribute} = $this->sessionId;    
        }
        $this->url = ['/' . Module::getInstance()->uniqueId . '/upload/index', 'sessionId'=>$this->sessionId];
        $this->name = 'file';
        $this->options['name'] = 'file';
        parent::init();
        $this->clientOptions['autoUpload'] = true;
        //$this->useDefaultButton = false;
        
    }
    
    public function run()
    {
        $input = $this->hasModel()
            ? Html::activeFileInput($this->model, $this->attribute, $this->options)
            : Html::fileInput($this->name, $this->value, $this->options);

        echo $this->useDefaultButton
            ? $this->render($this->viewUploadButton, ['input' => $input])
            : $input;

        $this->registerClientScript();
    }
    
    
}  

