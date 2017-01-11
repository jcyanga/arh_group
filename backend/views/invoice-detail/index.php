<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchInvoiceDetail */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Invoice Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'invoice_id',
            'service_part_id',
            'quantity',
            'selling_price',
            // 'subTotal',
            // 'created_at',
            // 'created_by',
            // 'type',
            // 'task',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
