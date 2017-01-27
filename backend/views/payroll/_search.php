<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Staff;

$dataStaff = ArrayHelper::map(Staff::find()->all(),'id','fullname');
/* @var $this yii\web\View */
/* @var $model common\models\SearchCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

 <div class="row">

    <div class="col-md-12">
        <div class="search-label-container">
            <span class="search-label"><li class="fa fa-edit"></li> Enter Keyword here</span>
        </div> 
    </div>
    <br/><br/>
    
    <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get', 'class' => 'form-inline']); ?>

    <div class="col-md-4">
        <?= $form->field($model, 'staff_id')->dropDownList($dataStaff, ['class' => 'form_input form-control'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <div style="margin-left: -10px;">
            <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'form-btn btn btn-primary']) ?>
        </div>
    </div>

    <div class="col-md-4"></div>

    <?php ActiveForm::end(); ?>
    <br/><br/>

 </div>





