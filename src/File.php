<?php

namespace chabberwock\files;

class File extends \yii\base\Model
{
    public $id;
    public $name;
    public $type;
    public $size;
    public $data;
    public $path;
    public $url;
    
    public function rules()
    {
        return [
            [['id','name','type'], 'required'],
            [['data','size'], 'safe']
        ];
    }
    
}  

