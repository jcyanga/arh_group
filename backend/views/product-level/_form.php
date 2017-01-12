<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Product Level Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">Critical Level</label>
        <?= $form->field($model, 'critical_level')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Enter Critical Level here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">Minimum Level</label>
       <?= $form->field($model, 'minimum_level')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Enter Minimum Level here.'])->label(false) ?>
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









