<?php
namespace chabberwock\files\controllers;

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new \chabberwock\files\UploadModel();
        
        return $this->render('index', ['model'=>$model]);
    }
}
  

