<?php

namespace backend\controllers;

use Yii;
use common\models\StockIn;

class ReportsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMonthlyStockReport() {
        $model = new StockIn();

        if( !empty(Yii::$app->request->get('date_start')) && !empty(Yii::$app->request->get('date_end')) ) {
            $date_start = Yii::$app->request->get('date_start');
            $date_end = Yii::$app->request->get('date_end');

            $getMonthlyStock = $model->getMonthlyStockByDateRange($date_start,$date_end);

        } else {
            $getMonthlyStock = $model->getMonthlyStock();

        }

    	return $this->render('monthly-stock-report',['getMonthlyStock' => $getMonthlyStock]);
    }

    public function actionMonthlySalesReport() {
    	echo 'monthly sales report.';
    }

    public function actionBestSellingProductReport() {
    	echo 'best selling product report.';
    }

}
