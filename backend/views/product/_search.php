<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCustomer */
/* @var $form yii\widgets\ActiveForm */
$dataCategory = ArrayHelper::map(Category::find()->all(), 'id', 'category');
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
        <?= $form->field($model, 'category_id')->dropDownList($dataCategory)->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'product_code')->textInput(['placeholder' => 'Enter Parts Code here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'product_name')->textInput(['placeholder' => 'Enter Parts Name here...'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-default']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
    <br/><br/>

 </div>











