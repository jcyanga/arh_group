<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

</style>

 <div class="row">

    <div class="col-md-12">
        <div class="search-label-container">
            <span class="search-label"><li class="fa fa-edit"></li> Enter Keyword here</span>
        </div> 
    </div>
    <br/><br/>
<!-- 'id' => 'demo-form2' -->
<!-- , 'class' => 'form-inline' -->
    <?php $form = ActiveForm::begin(['action' => ['index'],'method' => 'get', 'class' => 'form-inline']); ?>

    <div class="col-md-3">
        <?= $form->field($model, 'fullname')->textInput(['placeholder' => 'Enter Fullname here...'])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <?= $form->field($model, 'username')->textInput(['placeholder' => 'Enter Username here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Enter E-mail here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <br/><br/>

 </div>



