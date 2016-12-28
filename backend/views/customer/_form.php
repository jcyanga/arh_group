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
        <span class="search-label"><li class="fa fa-edit"></li> Customer Information.</span>
    </div>
    <br/>

    <div class="col-md-4">
        <label style="font-size: 12px;">FULLNAME</label>
        <?= $form->field($model, 'fullname')->textInput(['required' => 'required', 'placeholder' => 'Fullname here...'])->label(false) ?>
    </div>
    
    <div class="col-md-4">
        <label style="font-size: 11px;">ADDRESS</label>
        <?= $form->field($model, 'address')->textInput(['required' => 'required', 'placeholder' => 'Address here...'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <label style="font-size: 11px;">RACE</label>
        <?= $form->field($model, 'race')->textInput(['required' => 'required', 'placeholder' => 'Race here...'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-4">
        <label style="font-size: 11px;">E-MAIL ADDRESS</label>
        <?= $form->field($model, 'email')->textInput(['required' => 'required', 'placeholder' => 'Email Plate here...'])->label(false) ?>
    </div>
    
    <div class="col-md-4">
        <label style="font-size: 11px;">PHONE NUMBER</label>
        <?= $form->field($model, 'hanphone_no')->textInput(['required' => 'required', 'placeholder' => 'Hand-Phone Number here...'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <label style="font-size: 11px;">OFFICE NUMBER</label>
        <?= $form->field($model, 'office_no')->textInput(['required' => 'required', 'placeholder' => 'Office Number here...'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-truck"></li> Car Information.</span>
    </div>
    <br/>

    <div class="col-md-4">
        <label style="font-size: 11px;">IC</label>
        <?= $form->field($model, 'ic')->textInput(['required' => 'required', 'placeholder' => 'Car IC here...'])->label(false) ?>
    </div>
    
    <div class="col-md-4">
        <label style="font-size: 11px;">CAR PLATE</label>
        <?= $form->field($model, 'carplate')->textInput(['required' => 'required', 'placeholder' => 'Car Plate here...'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <label style="font-size: 11px;">CAR MODEL</label>
        <?= $form->field($model, 'model')->textInput(['required' => 'required', 'placeholder' => 'Car Model here...'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-4">
        <label style="font-size: 11px;">BATTERY/IES</label>
        <?= $form->field($model, 'batteries')->textInput(['required' => 'required', 'placeholder' => 'Battery/ies here...'])->label(false) ?>
    </div>
    
    <div class="col-md-4">
        <label style="font-size: 11px;">CAR BELT</label>
        <?= $form->field($model, 'belt')->textInput(['required' => 'required', 'placeholder' => 'Car Belt here...'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <label style="font-size: 11px;">CAR TYRE SIZE</label>
        <?= $form->field($model, 'tyre_size')->textInput(['required' => 'required', 'placeholder' => 'Car Tyre Size here...'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-4">
        <label style="font-size: 11px;">CAR MAKE</label>
                <?= $form->field($model, 'make')->textInput(['required' => 'required', 'placeholder' => 'Car Make here...'])->label(false) ?>
    </div>
    
    <div class="col-md-4"></div>

    <div class="col-md-4"></div>

</div>
<br/>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-comment"></li> Other Information.</span>
    </div>
    <br/>

    <div class="col-md-4">
        <label style="font-size: 11px;">REWARD POINTS</label>
        <?= $form->field($model, 'points')->textInput(['required' => 'required', 'placeholder' => 'Reward Points here...'])->label(false) ?>
    </div>
    
    <div class="col-md-4">
        <label style="font-size: 11px; font-weight: bold;">MEMBER EXPIRY</label>
        <?= $form->field($model, 'member_expiry')->textInput(['id' => 'expiry_date', 'required' => 'required', 'placeholder' => 'YYYY-MM-DD'])->label(false) ?>
    </div>

    <div class="col-md-4">
        <label style="font-size: 11px;">MEMBER</label>
        <?=  $form->field($model, 'is_member')->dropDownList(['1' => 'Yes', '0' => 'No'],['prompt'=>'Select Option'])->label(false) ?>           
    </div>

    <div >
        <?= $form->field($model, 'created_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'updated_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'status')->textInput(['type' => 'hidden', 'value' => '1'])->label(false) ?>
        <?= $form->field($model, 'is_blacklist')->textInput(['type' => 'hidden', 'value' => '0'])->label(false) ?>
        <?= $form->field($model, 'created_by')->textInput(['type' => 'hidden', 'value' => $userId])->label(false) ?>
     </div>     
     <br/>

     

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



