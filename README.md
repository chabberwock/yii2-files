# File uploads management module for Yii2

This module simplifies handling of async uploads. It provides special Session
object, that links uploaded files with your model, so you can easily process them
later. Based on 2amigos/yii2-file-upload-widget

## Installation

Add "chabberwock/yii2-files": "*" to "require" section of your composer.json

Once module is installed, add it to modules section of config

```
        'files' => [
            'class' => 'chabberwock\files\Module',
            'uploadDir' => __DIR__ . '/../uploads/temp', // temporary storage dir
            'expires' => 3600, // when old uploaded files should be removed
        ],
```
        
and to the bootstrap section
```
    'bootstrap' => ['files']
```

## Usage

In view: 
```
    // Basic upload
    <?= $form->field($model, 'session_id')->widget('\chabberwock\files\FileUpload') ?>
    // Basic plus UI upload
    <?= $form->field($model, 'session_id')->widget('\chabberwock\files\FileUploadUI') ?>
```

Where 'session_id' is a string attribute. Once model is submitted, session_id will contain
id of session, and can be easily accessed:

```
    $session = Yii::$app->getModule('files')->findSession($model->session_id);
    foreach ($session->listFiles() as $file) {
        $session->moveFile($file, '/public/uploads');
    }
```

## Module events

Module generates event on every file upload, that can be used to handle files:

```
        Yii::$app->on('files.upload', function ($event) use ($app) {
            /** @var \chabberwock\files\Session */
            $session = $event->session;
            if (isset($session->meta['target']) && $session->meta['target'] == 'embed') {
                $file = $event->file;
                $newname = uniqid() . '.' . $file->ext;
                $dirParts = [
                    '/uploads/embed',
                    date('Y'),
                    date('m'),
                    date('d'),
                    $newname
                ];
                $path = $app->basePath . implode(DIRECTORY_SEPARATOR, $dirParts);
                if (!file_exists(dirname($path))) {
                    mkdir(dirname($path), 0755, true);    
                }
                $session->moveFile($file, $path);
                chmod($path, 0755);
                $file->url = implode('/', $dirParts);
            }
        });
```












