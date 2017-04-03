<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create Customer';

?>

<div class="row form-container">

<div>
    <?php if($msg <> ''){ ?>
        <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
            <?php echo $msg; ?>
        </div>
    <?php } ?>
</div>
    
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-users"></i> Create Customer</h4></span>
    </div>
    <hr/>

    <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
    <br/><br/>

    <div class="form-crud-container">
        <?= $this->render('_customer-form', ['model' => $model, 'carModel' => $carModel ]) ?>
    </div>   
</div>

</div>
<br/>


