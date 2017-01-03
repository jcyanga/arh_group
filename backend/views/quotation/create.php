<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create Quotation';
// $this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];

?>

<div class="row form-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 
    <div class="form-title-container">
        <span style="color: #666;" class="form-header"><h4><i class="fa fa-pencil-square-o"></i>Create Quotation</h4></span>
    </div>
    <hr/>

    <!-- <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
    <br/><br/> -->

    <div class="form-crud-container">
        <?= $this->render('_form', ['model' => $model, 'quotationId' => $quotationId, 'getBranchList' => $getBranchList, 'getUserList' => $getUserList, 'getCustomerList' => $getCustomerList]) ?>
    </div>   
 
 </div>

</div>
<br/>




