<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create Customer';
// $this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];

?>

<div class="row form-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
  
    <div>
        <?php if($msg <> ''){ ?>
            <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
            <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
                <?php echo $msg; ?>
            </div>
        <?php } ?>
    </div>

    <div class="form-title-container">
        <span style="color: #666;" class="form-header"><h4>Create Customer</h4></span>
    </div>
    <hr/>

    <div class="form-crud-container">
        <?= $this->render('_form', ['model' => $model,]) ?>
    </div>   
 
 </div>

</div>
<br/>


