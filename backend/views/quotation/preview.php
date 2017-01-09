<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View Quotation';
// $this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="row form-container">
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">
    
 <div class="form-title-container">
    <span class="form-header"><h4><i class="fa fa-edit"></i> View Quotation Information</h4></span>
 </div>      
 <hr/>

 <div class="col-md-12">
    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-print"></i> Print Quotation', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>

        <?= Html::a( '<i class="fa fa-calculator"></i> Generate Invoice', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-success']); ?>
        
        <?= Html::a( '<i class="fa fa-pencil-square"></i> Update', '?r=supplier/update&id=' . $model->id, ['class' => 'form-btn btn btn-info']); ?>

        <?= Html::a( '<i class="fa fa-trash"></i> Delete', '?r=supplier/delete-column&id=' . $model->id, ['class' => 'form-btn btn btn-danger', 'onclick' => 'return deleteConfirmation()']); ?>
    </div>
 </div>    
 <hr/><br/>

<div class="col-md-6">
    
</div>
<div class="col-md-6">b</div>

    <div class="tbl-container">
        <table class="table table-boardered">
                <tr>
                    <td>Quotation Code</td>
                    <td><?php echo $customerInfo['quotation_code']; ?></td>
                    <td>Date Issue</td>
                    <td><?php echo $customerInfo['date_issue']; ?></td>
                </tr>
                <tr>
                    <td>Branch Name</td>
                    <td><?php echo $customerInfo['name']; ?></td>
                    <td>Sales Person</td>
                    <td><?php echo $customerInfo['salesPerson']; ?></td>
                </tr>
                <tr>
                    <td>Customer Name</td>
                    <td><?php echo $customerInfo['fullname']; ?></td>
                    <td></td>
                    <td></td>
                </tr>
        </table>
        <br/>
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Services / Parts</td>
                    <td>Qty</td>
                    <td>Selling Price</td>
                    <td>Sub-Total</td>
                </tr>
            </thead>
            <?php foreach($services as $sRow): ?>
                <tr>
                    <td><?php echo $sRow['service_name']; ?></td>
                    <td><?php echo $sRow['quantity']; ?></td>
                    <td><?php echo $sRow['selling_price']; ?></td>
                    <td><?php echo $sRow['subTotal']; ?></td>
                </tr>
            <?php endforeach; ?>  
            <?php foreach($parts as $pRow): ?>
                <tr>
                    <td><?php echo $pRow['product_name']; ?></td>
                    <td><?php echo $pRow['quantity']; ?></td>
                    <td><?php echo $pRow['selling_price']; ?></td>
                    <td><?php echo $pRow['subTotal']; ?></td>
                </tr>
            <?php endforeach; ?> 
        </table>
        <br/>
    </div>   
 
 </div>

</div>
<br/>





    
