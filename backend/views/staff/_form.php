<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$dataStatus = array('' => 'CHOOSE STATUS HERE', '0' => 'INACTIVE', '1' => 'ACTIVE');
$dateNow = date('Y-m-d');
$userId = Yii::$app->user->identity->id;
$staffCode = 'STAFF' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5); 

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Staff Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">Code</label>
        <?= $form->field($model, 'staff_code')->textInput(['class' => 'form_input form-control', 'readonly' => 'readonly', 'value' => $staffCode])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">Fullname</label>
        <?= $form->field($model, 'fullname')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Staff Name here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">Status</label>
        <?= $form->field($model, 'status')->dropDownList($dataStatus,['class' => 'form_input form-control', 'required' => 'required'])->label(false) ?>
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
    
</div>
<br/><br/>

<?php ActiveForm::end(); ?>









