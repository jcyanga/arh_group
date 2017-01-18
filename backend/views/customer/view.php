<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View Customer';

?>

<div class="row form-container">
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">
    
 <div class="form-title-container">
    <span class="form-header"><h4>View Customer Information</h4></span>
 </div>      
 <hr/>

 <div class="col-md-12">
    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>

        <?= Html::a( '<i class="fa fa-pencil-square"></i> Update', '?r=customer/update&id=' . $model->id, ['class' => 'form-btn btn btn-info']); ?>

        <?= Html::a( '<i class="fa fa-trash"></i> Delete', '?r=customer/delete-column&id=' . $model->id, ['class' => 'form-btn btn btn-danger', 'onclick' => 'return deleteConfirmation()']); ?>
    </div>
 </div>    
 <br/>

 <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="tbl-container viewDesign">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fullname',
            'race',
            'carplate',
            'address:ntext',
            'hanphone_no',
            'office_no',
            'email:email',
            'remarks',
            'make',
            'model',
            [
                'label' => 'Is Blacklist',
                'value' => $model->is_blacklist ? 'Yes' : 'No',
            ],
            [
                'label' => 'Is Member',
                'value' => $model->is_member ? 'Yes' : 'No',
            ], 
            'points',
            'member_expiry'
        ],
        ]) ?>
        <br/>
    </div>   
 
 </div>

</div>
<br/>
