<?php
namespace chabberwock\files;

class UploadModel extends \yii\base\Model
{
    public $files;
    public $sessionId;
    
    public function rules()
    {
        return [
            [['files','sessionId'], 'safe']
        ];
    }
}  

