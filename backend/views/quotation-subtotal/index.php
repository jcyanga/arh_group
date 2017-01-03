<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchQuotationSubtotal */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quotation Subtotals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quotation-subtotal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Quotation Subtotal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'quotation_id',
            'item_id',
            'qty',
            'price',
            // 'subTotal',
            // 'type',
            // 'created_at',
            // 'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
