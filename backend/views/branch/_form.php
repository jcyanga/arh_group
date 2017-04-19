<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$branchCode = 'BRANCH' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5); 

if(!is_null(Yii::$app->request->get('id')) || Yii::$app->request->get('id') <> ''){
    $id = Yii::$app->request->get('id'); 
}else{
    $id = 0;
}

?>

<?php $form = ActiveForm::begin(['id' => 'arh-form']); ?>

<div class="row">
    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Branch Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">Branch Code</label>
        <input type="hidden" name="id" id="id" value="<?= $id ?>" />
        <?= $form->field($model, 'code')->textInput(['class' => 'form_input form-control', 'readonly' => 'readonly', 'value' => $branchCode, 'id' => 'branchCode' ])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">Branch Name</label>
        <?= $form->field($model, 'name')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Branch Name here.', 'id' => 'branchName' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-6">
        <label class="form_label">Address</label>
        <?= $form->field($model, 'address')->textarea(['class' => 'form_input form-control', 'placeholder' => 'Write Address here.', 'id' => 'branchAddress' ])->label(false) ?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-3">
        <label class="form_label">Contact Number</label>
        <?= $form->field($model, 'contact_no')->textInput(['class' => 'form_input form-control', 'data-parsley-type' => 'number', 'placeholder' => 'Write Contact Number here.', 'id' => 'branchContactNo' ])->label(false) ?>
    </div>
</div>
<hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitBranchForm' : 'saveBranchForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>







