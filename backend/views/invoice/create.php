<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create Invoice';
// $this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];

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
        <span style="color: #666;" class="form-header"><h4><i class="fa fa-pencil"></i> Create Invoice</h4></span>
    </div>
    <hr/>

    <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
    <br/><br/>

    <div class="form-crud-container">
        <?= $this->render('_form', ['model' => $model, 'invoiceId' => $invoiceId, 'getBranchList' => $getBranchList, 'getUserList' => $getUserList, 'getCustomerList' => $getCustomerList, 'getServicesList' => $getServicesList, 'getPartsList' => $getPartsList, 'errTypeHeader' => $errTypeHeader, 'errType' => $errType, 'msg' => $msg]) ?>
    </div>   
</div>

</div>
<br/>




