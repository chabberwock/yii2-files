<?php
namespace chabberwock\files;

use dosamigos\fileupload\FileUploadUI;

class FileUpload extends FileUploadUI
{
    public $sessionId;
    public $sessionConfig = array();
    
    
    public $formView = '@dosamigos/fileupload/views/form';
    public $uploadTemplateView = '@dosamigos/fileupload/views/upload';
    public $downloadTemplateView = '@dosamigos/fileupload/views/download';
    public $galleryTemplateView = '@dosamigos/fileupload/views/gallery';
    

    
    public function init()
    {
        if (!isset($this->sessionId)) {
            $session = Module::getInstance()->createSession($this->sessionConfig);
            $this->sessionId = $session->id;
        }
        $this->model->{$this->attribute} = $this->sessionId;
        $this->url = ['/' . Module::getInstance()->uniqueId . '/upload/index', 'sessionId'=>$this->sessionId];
        parent::init();
        $this->clientOptions['autoUpload'] = true;
        $this->fieldOptions['name'] = 'file';
        
    }
    
}  

