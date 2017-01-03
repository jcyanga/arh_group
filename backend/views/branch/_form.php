<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$dataStatus = array('' => 'Choose Status', '0' => 'Inactive', '1' => 'Active');

$dateNow = date('Y-m-d');

$userId = Yii::$app->user->identity->id;
?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Branch Information.</span>
    </div>
    <br/>

    <div class="col-md-4">
        <label style="font-size: 12px;">Branch Code</label>
        <?= $form->field($model, 'code')->textInput(['required' => 'required', 'placeholder' => 'Branch Code here...'])->label(false) ?>
    </div>
    
    <div class="col-md-4">
        <label style="font-size: 12px;">Branch Name</label>
        <?= $form->field($model, 'name')->textInput(['required' => 'required', 'placeholder' => 'Branch Name here...'])->label(false) ?>
    </div>

    <div class="col-md-4"></div>
</div>
<br/>

<div class="row">

    <div class="col-md-4">
        <label style="font-size: 12px;">Address</label>
        <?= $form->field($model, 'address')->textInput(['required' => 'required', 'placeholder' => 'Address here...'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <label style="font-size: 12px;">Contact Number</label>
        <?= $form->field($model, 'contact_no')->textInput(['required' => 'required', 'placeholder' => 'Contact Number here...'])->label(false) ?>
    </div>

    <div class="col-md-4">
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









