<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View Supplier';
// $this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="row form-container">
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">
    
 <div class="form-title-container">
    <span class="form-header"><h4>View Supplier Information</h4></span>
 </div>      
 <hr/>

 <div class="col-md-12">
    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>

        <?= Html::a( '<i class="fa fa-pencil-square"></i> Update', '?r=supplier/update&id=' . $model['id'], ['class' => 'form-btn btn btn-info']); ?>

        <?= Html::a( '<i class="fa fa-trash"></i> Delete', '?r=supplier/delete-column&id=' . $model['id'], ['class' => 'form-btn btn btn-danger', 'onclick' => 'return deleteConfirmation()']); ?>
    </div>
 </div>    
 <br/>

    <div class="tbl-container">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'supplier_code',
            'supplier_name',
            'product_code',
            'product_name',
            'quantity',
            'cost_price',
            'selling_price',
            'date_imported',
            'created_at',
        ],
        ]) ?>
        <br/>
    </div>   
 
 </div>

</div>
<br/>




