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
$passwordCode = substr(uniqid('', true), -8);

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Customer Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">FULLNAME</label>
        <?= $form->field($model, 'fullname')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Customer Fullname here.'])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <label class="form_label">ADDRESS</label>
        <?= $form->field($model, 'address')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Address here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">RACE</label>
        <?= $form->field($model, 'race')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Race here.'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label class="form_label">E-MAIL ADDRESS</label>
        <?= $form->field($model, 'email')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Email Address here.'])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <label class="form_label">PHONE NUMBER</label>
        <?= $form->field($model, 'hanphone_no')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Phone Number here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">OFFICE NUMBER</label>
        <?= $form->field($model, 'office_no')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Office Number here.'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-truck"></li> Car Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">IC</label>
        <?= $form->field($model, 'ic')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Car IC here.'])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <label class="form_label">CAR PLATE</label>
        <?= $form->field($model, 'carplate')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Car Plate here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">CAR MODEL</label>
        <?= $form->field($model, 'model')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Car Model here.'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label  class="form_label">CAR MAKE</label>
                <?= $form->field($model, 'make')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Car Make here.'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-comment"></li> Other Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label  class="form_label">REWARD POINTS</label>
        <?= $form->field($model, 'points')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Reward Points here.'])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <label  class="form_label">MEMBER EXPIRY</label>
        <?= $form->field($model, 'member_expiry')->textInput(['class' => 'form_input form-control', 'readonly' => 'readonly', 'id' => 'expiry_date', 'placeholder' => 'YYYY-MM-DD'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label  class="form_label">MEMBER</label>
        <?=  $form->field($model, 'is_member')->dropDownList(['' => 'CHOOSE STATUS HERE', '1' => 'Yes', '0' => 'No'],['class' => 'form_input form-control', 'required' => 'required'])->label(false) ?>           
    </div>
    <br/>

    <div class="col-md-6">
        <label  class="form_label">REMARKS</label>
         <textarea name="Customer[remarks]" style="font-size: 11.5px;" placeholder="Write your remarks here." id="message" required="required" class="qtxtarea form-control" data-parsley-trigger="keyup" data-parsley-minlength="10" data-parsley-maxlength="300" data-parsley-minlength-message="You need to enter at least a 10 caracters long comment." data-parsley-validation-threshold="10"></textarea>           
    </div>

    <div >
        <?= $form->field($model, 'created_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'updated_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'status')->textInput(['type' => 'hidden', 'value' => '1'])->label(false) ?>
        <?= $form->field($model, 'is_blacklist')->textInput(['type' => 'hidden', 'value' => '0'])->label(false) ?>
        <?= $form->field($model, 'created_by')->textInput(['type' => 'hidden', 'value' => $userId])->label(false) ?>
        <?= $form->field($model, 'password')->hiddenInput(['value' => $passwordCode])->label(false) ?>
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



