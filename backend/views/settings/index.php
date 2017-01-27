<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use common\models\Customer;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';

?>

<?php $form = ActiveForm::begin(); ?>

<div class="row form-container">

 <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-wrench"></i> Settings</h4></span>
    </div>
    <hr/>

 </div>

 <div class="col-md-12 col-sm-12 col-xs-12">

 	<h4><i class="fa fa-pencil-square-o"></i> Change Account Information</h4>

 </div>
 <br/>

 <div class="col-md-12">
 	<?= $form->form($model, 'username')->textInput(['class' => 'form-control'])->label(false) ?>
 </div>

</div>
<br/>

<?php ActiveForm::end(); ?>