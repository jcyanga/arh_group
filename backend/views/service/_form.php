<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\ServiceCategory;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$dataServiceCategory = ArrayHelper::map(ServiceCategory::find()->all(), 'id', 'name');

$dataStatus = array('' => 'Choose Status', '0' => 'Inactive', '1' => 'Active');

$dateNow = date('Y-m-d');

$userId = Yii::$app->user->identity->id;
?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Service Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label style="font-size: 12px;">Service Category</label>
        <?= $form->field($model, 'service_category_id')->dropDownList($dataServiceCategory,['required', 'required'])->label(false) ?>
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>

</div>   
<br/>

<div class="row">

    <div class="col-md-3">
        <label style="font-size: 12px;">Service Name</label>
        <?= $form->field($model, 'service_name')->textInput(['required' => 'required', 'placeholder' => 'Service Name here...'])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <label style="font-size: 12px;">Description</label>
        <?= $form->field($model, 'description')->textInput(['required' => 'required', 'placeholder' => 'Description here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label style="font-size: 12px;">Default Price</label>
        <?= $form->field($model, 'default_price')->textInput(['required' => 'required', 'placeholder' => 'Default Price here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label style="font-size: 12px;">Status</label>
        <?= $form->field($model, 'status')->dropDownList($dataStatus,['required' => 'required'])->label(false) ?>
    </div>

    <div>
        <?= $form->field($model, 'created_at')->hiddenInput(['value' => $dateNow])->label(false) ?>
        <?= $form->field($model, 'updated_at')->hiddenInput(['value' => $dateNow])->label(false) ?>
        <?= $form->field($model, 'created_by')->hiddenInput(['value' => $userId])->label(false) ?>
        <?= $form->field($model, 'updated_by')->hiddenInput(['value' => $userId])->label(false) ?>
    </div>

</div>
<hr/>

<div class="row">

    <div class="col-md-4">
        <?= Html::submitButton($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Update Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>
    
    <div class="col-md-4"></div>

    <div class="col-md-4"></div>

</div>
<br/><br/>

<?php ActiveForm::end(); ?>









