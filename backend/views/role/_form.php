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
                <?= $form->field($model, 'role')->textInput(['maxlength' => true, 'id' => 'role', 'class' => 'span3 m-wrap', 'placeholder' => 'Role here...']) ?>
            </div>

		    <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<li class=\'icon-save\'></li> Create New Record' : '<li class=\'icon-save\'></li> Update the Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
                <?= Html::resetButton('<li class=\'icon-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
            </div>

		    <?php ActiveForm::end(); ?>
		    <br/><br/><br/>
		</div>
</div>
