<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Role;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCustomer */
/* @var $form yii\widgets\ActiveForm */
$dataRole = ArrayHelper::map(Role::find()->all(), 'id', 'role');
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
        <?= $form->field($model, 'role_id')->dropDownList($dataRole)->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'controller')->textInput(['placeholder' => 'Enter Controller here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'action')->textInput(['placeholder' => 'Enter Actions here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-default']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
    <br/><br/>

 </div>











