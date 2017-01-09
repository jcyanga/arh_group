<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;
$supplierCode = 'SUPPLIERS' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Supplier Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">Supplier Code</label>
        <?= $form->field($model, 'supplier_code')->textInput(['class' => 'form_input form-control', 'readonly' => 'readonly', 'value' => $supplierCode])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <label class="form_label">Supplier Name</label>
        <?= $form->field($model, 'supplier_name')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Supplier Name here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">Address</label>
        <?= $form->field($model, 'address')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Address here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">Contact Number</label>
        <?= $form->field($model, 'contact_number')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Contact Number here.'])->label(false) ?>
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









