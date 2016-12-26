<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$datetime = date('Y-m-d h:i:s');
?>

<div>
    <?php $form = ActiveForm::begin(['class' => 'form-inline']); ?>
    
        <div class="search-label-container">
            <span class="search-label"><li class="icon-edit"></li> Fill-up all the field.</span>
        </div>

            <div class="floating-box">
                <?= $form->field($model, 'supplier_code')->textInput(['maxlength' => true, 'id' => 'supplier_code', 'class' => 'span3 m-wrap', 'placeholder' => 'Supplier Code here...']) ?>
            </div>

            <div class="floating-box">
                <?= $form->field($model, 'supplier_name')->textInput(['maxlength' => true, 'id' => 'supplier_name', 'class' => 'span3 m-wrap', 'placeholder' => 'Supplier Name here...']) ?>
            </div>

            <div class="floating-box">
                <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'id' => 'address', 'class' => 'span3 m-wrap', 'placeholder' => 'Address here...']) ?>
            </div>

            <div class="floating-box">
                <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true, 'id' => 'contact_number', 'class' => 'span3 m-wrap', 'placeholder' => 'Contact Number here...']) ?>
            </div>

		    <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<li class=\'icon-save\'></li> Create New Record' : '<li class=\'icon-save\'></li> Update the Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
                <?= Html::resetButton('<li class=\'icon-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
            </div>

		    <?php ActiveForm::end(); ?>
		    <br/><br/><br/>
		</div>
</div>


