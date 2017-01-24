<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Customer;

class DashboardController extends Controller
{
    public function actionLogin()
    {
    	$this->layout = false;
    	$model = new Customer();
    	print_r($model);
        // return $this->render('login',['model' => $model]);
    }

}
