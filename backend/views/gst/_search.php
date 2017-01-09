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

    <div class="col-md-4">
        <?= $form->field($model, 'branch_id')->dropDownList($dataBranch, ['class' => 'form_input form-control', 'required' => 'required'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-default']) ?>
    </div>

    <div class="col-md-3"></div>

    <?php ActiveForm::end(); ?>
    <br/><br/>

 </div>





