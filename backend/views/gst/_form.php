<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use yii\helpers\ArrayHelper;
use common\models\Branch;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$dataBranch = ArrayHelper::map(Branch::find()->all(), 'id', 'name');

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

	<div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Gst Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">Status</label>
        <?= $form->field($model, 'branch_id')->dropDownList($dataBranch, ['class' => 'form_input form-control', 'required' => 'required'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">GST</label>
        <?= $form->field($model, 'gst')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write GST here.'])->label(false) ?>
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









