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

<div>
    <?php $form = ActiveForm::begin(['class' => 'form-inline']); ?>
    
        <div class="search-label-container">
            <span class="search-label"><li class="icon-edit"></li> Customer Information.</span>
        </div>

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">FULLNAME</label>
                <?= $form->field($model, 'fullname')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;', 'maxlength' => true, 'id' => 'c_fullname', 'class' => 'span3 m-wrap', 'placeholder' => 'Fullname here...'])->label(false) ?>
             </div>
             <br/>

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">ADDRESS</label>
                <?= $form->field($model, 'address')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_address', 'class' => 'span3 m-wrap', 'placeholder' => 'Address here...'])->label(false) ?>
             </div>

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">RACE</label>
                <?= $form->field($model, 'race')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_race', 'class' => 'span3 m-wrap', 'placeholder' => 'Race here...'])->label(false) ?>
             </div>

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">E-MAIL ADDRESS</label>
                <?= $form->field($model, 'email')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_email', 'class' => 'span3 m-wrap', 'placeholder' => 'Email Plate here...'])->label(false) ?>
             </div>
             <br/>

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">PHONE NUMBER</label>
                <?= $form->field($model, 'hanphone_no')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_hphonenum', 'class' => 'span3 m-wrap', 'placeholder' => 'Hand-Phone Number here...'])->label(false) ?>
             </div> 

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">OFFICE NUMBER</label>
                <?= $form->field($model, 'office_no')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_race', 'class' => 'span3 m-wrap', 'placeholder' => 'Office Number here...'])->label(false) ?>
             </div>   

        <div class="search-label-container">
            <span class="search-label"><li class="icon-truck"></li> Car Information.</span>
        </div>

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">IC</label>
                <?= $form->field($model, 'ic')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_ic', 'class' => 'span3 m-wrap', 'placeholder' => 'Car IC here...'])->label(false) ?>
             </div> 

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">CAR PLATE</label>
                <?= $form->field($model, 'carplate')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_carplate', 'class' => 'span3 m-wrap', 'placeholder' => 'Car Plate here...'])->label(false) ?>
             </div>  

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">CAR MODEL</label>
                <?= $form->field($model, 'model')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_model', 'class' => 'span3 m-wrap', 'placeholder' => 'Car Model here...'])->label(false) ?>
             </div>   

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">BATTERY/IES</label>
                <?= $form->field($model, 'batteries')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_batteries', 'class' => 'span3 m-wrap', 'placeholder' => 'Battery/ies here...'])->label(false) ?>
             </div>  

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">CAR BELT</label>
                <?= $form->field($model, 'belt')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_belt', 'class' => 'span3 m-wrap', 'placeholder' => 'Car Belt here...'])->label(false) ?>
             </div> 

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">CAR TYRE SIZE</label>
                <?= $form->field($model, 'tyre_size')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_tyresize', 'class' => 'span3 m-wrap', 'placeholder' => 'Car Tyre Size here...'])->label(false) ?>
             </div> 

             <div class="floating-box">
                <label style="font-size: 11px; font-weight: bold;">CAR MAKE</label>
                <?= $form->field($model, 'make')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_make', 'class' => 'span3 m-wrap', 'placeholder' => 'Car Make here...'])->label(false) ?>
             </div> 

        <div class="search-label-container">
            <span class="search-label"><li class="icon-comment"></li> Other Information.</span>
        </div>

             <div class="floating-box">
             <label style="font-size: 11px; font-weight: bold;">CUSTOMER REWARD POINTS</label>
                <?= $form->field($model, 'points')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','maxlength' => true, 'id' => 'c_points', 'class' => 'span3 m-wrap', 'placeholder' => 'Reward Points here...'])->label(false) ?>
             </div> 

             <div class="floating-box">
             <label style="font-size: 11px; font-weight: bold;">MEMBER EXPIRY</label>
                <?= $form->field($model, 'member_expiry')->textInput(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;','id' => 'date', 'data-select' => 'datepicker', 'placeholder' => 'YYYY-MM-DD'])->label(false) ?>
             </div> 
             <br/>

             <div class="floating-box">
                <?= $form->field($model, 'is_member')->checkbox(['style' => 'border: solid 1px #eee; box-shadow: .5px .5px .5px .5px; font-size: 12px;', 'class' => 'form-control', 'value' => 'Checked'])->label(false) ?> 
             </div> 

             <div >
                <?= $form->field($model, 'created_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
                <?= $form->field($model, 'updated_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
                <?= $form->field($model, 'status')->textInput(['type' => 'hidden', 'value' => '1'])->label(false) ?>
                <?= $form->field($model, 'is_blacklist')->textInput(['type' => 'hidden', 'value' => '0'])->label(false) ?>
                <?= $form->field($model, 'created_by')->textInput(['type' => 'hidden', 'value' => $userId])->label(false) ?>
             </div>     
             <br/>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<li class=\'icon-save\'></li> Create New Record' : '<li class=\'icon-save\'></li> Update the Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
                <?= Html::resetButton('<li class=\'icon-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
            </div>

    <?php ActiveForm::end(); ?>
    <br/><br/><br/>
</div>

