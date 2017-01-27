<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\SearchUser;

class SettingsController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$id = Yii::$app->user->identity->id;

        // return $this->render('index', [
        // 					'model' => User::findOne($id),
        // 				]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
