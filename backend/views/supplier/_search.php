<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

</style>

<div  class="supplier-search">
    <div class="search-label-container">
        <span class="search-label"><li class="icon-edit"></li> Enter Keyword here</span>
    </div>  

    <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get', 'class' => 'form-inline']); ?>
     
     <div class="floating-box">
        <?= $form->field($model, 'id')->textInput(['autocomplete' => 'off', 'class' => 'form-input', 'placeholder' => 'Enter ID here...'])->label(false) ?>
     </div>

     <div class="floating-box">
        <?= $form->field($model, 'supplier_code')->textInput(['autocomplete' => 'off', 'class' => 'form-input', 'placeholder' => 'Enter Supplier Code here...'])->label(false) ?>
     </div>

     <div class="floating-box">
        <?= $form->field($model, 'supplier_name')->textInput(['autocomplete' => 'off', 'class' => 'form-input', 'placeholder' => 'Enter Supplier Name here...'])->label(false) ?>
     </div>
     <br/>
     
     <div class="floating-box">
        <?= Html::submitButton('<li class=\'icon-search\'></li> Search', ['class' => 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'icon-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-default']) ?>

     </div>

    <?php ActiveForm::end(); ?>

</div>





