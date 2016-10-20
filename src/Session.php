<?php
namespace chabberwock\files;

use yii\helpers\FileHelper;

class Session extends \yii\base\Model
{
    public $id;
    public $meta;
    
    public function rules()
    {
        return [
            ['id', 'required'],
            ['meta', 'safe'],
        ];
    }
    
    private static function directory($sessionId)
    {
        return Module::getInstance()->uploadDir . DIRECTORY_SEPARATOR . $sessionId;
    }
    
    private static function configFile($sessionId) 
    {
        return self::directory($sessionId) . DIRECTORY_SEPARATOR . 'session.bin';
    }
    
    private static function filePath($sessionId, $fileId) 
    {
        return self::directory($sessionId) . DIRECTORY_SEPARATOR . $fileId . '.file';
    }

    private static function fileMeta($sessionId, $fileId) 
    {
        return self::directory($sessionId) . DIRECTORY_SEPARATOR . $fileId . '.meta';
    }
    
    public static function cleanup()
    {
        foreach (glob(Module::getInstance()->uploadDir . '/*', GLOB_ONLYDIR) as $sessionDir)
        {
            if ((time() - filemtime($sessionDir)) > Module::getInstance()->expires) {
                FileHelper::removeDirectory($sessionDir);    
            }
        }
        
    }
    
    public static function create($meta)
    {
        self::cleanup();
        $session = new Session();
        $session->id = uniqid();
        $session->meta = $meta;
        $session->save();
        return $session;
    }
    
    /**
    * put your comment there...
    * 
    * @param mixed $id
    * @return Session
    */
    public static function find($id)
    {
        if (file_exists(self::configFile($id))) {
            $session = new Session(unserialize(file_get_contents(self::configFile($id))));
            return $session;
        }
        return false;
    }
    
    public function save()
    {
        $dir = self::directory($this->id);
        
        if (!file_exists($dir)) {
            mkdir($dir, 0700, true);
        }
        file_put_contents(self::configFile($this->id), serialize($this->toArray()));
    }
    
    public function addFile($path, $config)
    {
        $file = new File();
        $file->id = uniqid();
        $file->load(['File'=>$config]);
        $file->size = filesize($path);
        if ($file->validate()) {
            file_put_contents(self::fileMeta($this->id, $file->id), serialize($file->toArray()));
            move_uploaded_file($path, self::filePath($this->id, $file->id));
            return $file;
        } else {
            return false;    
        }
    }
    
    public function moveFile(File $file, $newName)
    {
        rename(self::filePath($this->id, $file->id), $newName);
        unlink(self::fileMeta($this->id, $file->id));
    }
    
    public function deleteFile(File $file)
    {
        unlink(self::filePath($this->id, $file->id));
        unlink(self::fileMeta($this->id, $file->id));
    }
    
    
    public function listFiles()
    {
        $dir = self::directory($this->id);
        $files == [];
        foreach (glob($dir . DIRECTORY_SEPARATOR . '*.meta') as $metaFile) {
            $files[] = new File(unserialize(file_get_contents($metaFile)));    
        }
        return $files;
    }
    
    public function getFile($id)
    {
        $files = $this->listFiles();
        if (empty($files)) {
            return false;
        }
        foreach ($files as $file) {
            if ($file->id == $id) {
                return $file;
            }
        }
    }
    
    public function readFile(File $file)
    {
        readfile(self::filePath($this->id, $file->id));
    }
    
    
    
    
}  

