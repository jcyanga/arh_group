<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View Category';
// $this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="row form-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
  
    <div class="form-title-container">
        <span class="form-header"><h4>View Category Information</h4></span>
    </div>      
    <hr/>

    <div class="tbl-container">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category'
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
        ],
        ]) ?>
        <br/>
    </div>   
 
 </div>

</div>
<br/>





    
