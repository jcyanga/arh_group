<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\ServiceCategory;

$dataServiceCategory = ArrayHelper::map(ServiceCategory::find()->all(), 'id', 'name');
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
        <?= $form->field($model, 'service_category_id')->dropDownList($dataServiceCategory,['class' => 'form_input form-control'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'service_name')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Service Name here.'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <div style="margin-left: -10px;">
            <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'form-btn btn btn-primary']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
    <br/><br/>

 </div>











