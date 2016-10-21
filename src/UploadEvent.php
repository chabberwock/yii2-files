<?php
namespace chabberwock\files;

use yii\base\Event;

class UploadEvent extends Event
{
    /** @var Session */
    public $session;
    /** @var File */
    public $file;
}

