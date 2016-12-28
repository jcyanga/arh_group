<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$member_list = array('0' => 'No', '1' => 'Yes');

$datetime = date('Y-m-d h:i:s');

$userId = Yii::$app->user->identity->id;
?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Supplier Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label style="font-size: 12px;">Supplier Code</label>
        <?= $form->field($model, 'supplier_code')->textInput(['required' => 'required', 'placeholder' => 'Supplier Code here...'])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <label style="font-size: 12px;">Supplier Name</label>
        <?= $form->field($model, 'supplier_name')->textInput(['required' => 'required', 'placeholder' => 'Supplier Name here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label style="font-size: 12px;">Address</label>
        <?= $form->field($model, 'address')->textInput(['required' => 'required', 'placeholder' => 'Address here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label style="font-size: 12px;">Contact Number</label>
        <?= $form->field($model, 'contact_number')->textInput(['required' => 'required', 'placeholder' => 'Contact Number here...'])->label(false) ?>
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









