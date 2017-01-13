<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;
use common\models\Invoice;

$getGst = Gst::find()->where(['branch_id' => $customerInfo['BranchId'] ])->one();

if( isset($getGst->gst) ) {
    $gst = $getGst->gst;
    $getSubTotal = $customerInfo['grand_total'] / $gst;
}else{
    $gst = 0.00;
    $getSubTotal = $customerInfo['grand_total'] / $gst;
}

$getInvoice = Invoice::find()->where(['quotation_code' => $customerInfo['quotation_code'] ])->one();

$this->title = 'View Quotation';
// $this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$invoiceNo = 'Arh' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);


?>

<div class="book">
    <div class="page">
        <div class="subpage">Page 1/2</div>    
    </div>
    <div class="page">
        <div class="subpage">Page 2/2</div>    
    </div>
</div>

    <!-- this row will not appear when printing -->
    <hr/>
    <div class="row no-print">
        <div class="col-xs-12">

            <button class="btn btn-default pull-right" onclick="quotationPrint()"><i class="fa fa-print"></i> Print Quotation</button>

        </div>
    </div>
</section>





    
