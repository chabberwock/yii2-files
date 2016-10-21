<?php
namespace chabberwock\files;

use dosamigos\fileupload\FileUploadUI as BaseWidget;

class FileUploadUI extends BaseWidget
{
    public $sessionId;
    public $meta = array();
    
    
    public $formView = '@dosamigos/fileupload/views/form';
    public $uploadTemplateView = '@dosamigos/fileupload/views/upload';
    public $downloadTemplateView = '@dosamigos/fileupload/views/download';
    public $galleryTemplateView = '@dosamigos/fileupload/views/gallery';
    

    
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
        parent::init();
        $this->clientOptions['autoUpload'] = true;
        $this->fieldOptions['name'] = 'file';
        
    }
    
}  

