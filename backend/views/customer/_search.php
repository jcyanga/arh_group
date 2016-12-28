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
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Enter Email here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'carplate')->textInput(['placeholder' => 'Enter Car-Plate here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <br/><br/>

 </div>


 
    <!-- <?= $form->field($model, 'carplate') ?>

    <?= $form->field($model, 'address') ?> -->

    <?php // echo $form->field($model, 'hanphone_no') ?>

    <?php // echo $form->field($model, 'office_no') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'make') ?>

    <?php // echo $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'tyre_size') ?>

    <?php // echo $form->field($model, 'batteries') ?>

    <?php // echo $form->field($model, 'belt') ?>

    <?php // echo $form->field($model, 'is_blacklist') ?>

    <?php // echo $form->field($model, 'is_member') ?>

    <?php // echo $form->field($model, 'points') ?>

    <?php // echo $form->field($model, 'member_expiry') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>




