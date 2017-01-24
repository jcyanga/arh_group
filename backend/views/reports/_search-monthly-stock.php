<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCustomer */
/* @var $form yii\widgets\ActiveForm */

if( !empty(Yii::$app->request->get('date_start')) || !empty(Yii::$app->request->get('date_end')) ) {
    $date_start = Yii::$app->request->get('date_start');
    $date_end = Yii::$app->request->get('date_end');

}else{
    $date_start = '';
    $date_end = '';

}

?>

 <div class="row">

    <div class="col-md-12">
        <div class="search-label-container">
            <span class="search-label"><li class="fa fa-calendar-o"></li> Enter Date-range here</span>
        </div> 
    </div>
    <br/><br/>
    
    <?php $form = ActiveForm::begin(['action' => '?r=reports/monthly-stock-report','method' => 'get', 'class' => 'form-inline']); ?>

    <div class="col-md-3">
        <input type="text" name="date_start" id="datestart" class="form_input form-control" placeholder="Date Start" value="<?= $date_start ?>"  readonly />
    </div>

    <div class="col-md-3">
        <input type="text" name="date_end" id="dateend" class="form_input form-control" placeholder="Date End" value="<?= $date_end ?>" readonly />
    </div>

    <div class="col-md-3">
        <?= Html::Button('<li class=\'fa fa-search\'></li> Search', ['type' => 'submit', 'class' => 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-default']) ?>
    </div>

    <div class="col-md-3"></div>

    <?php ActiveForm::end(); ?>
    <br/>

 </div>





