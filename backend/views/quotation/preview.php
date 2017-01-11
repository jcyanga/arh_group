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

<div class="row printform-container">

<div style="margin: 0 auto;" class="col-md-12">

<div class="x_panel">

    <div class="x_title">
        <h2> Arh Group Pte Ltd. - Quotation.</h2>
        <div class="clearfix"></div>
    </div>

<div class="x_content">

<!-- info row -->
<div  style="margin: 0 auto;" class="row ">

    <div class="col-md-12">
        <address style="text-align: center;">
            <strong>Branch Prepared: <?= $customerInfo['name'] ?></strong>
            <br><small><?= $customerInfo['address'] ?></small>
            <br><small>Contact No.  <?= $customerInfo['branchNumber'] ?></small>
            <br><small><strong>Prepared By: <?= $customerInfo['salesPerson'] ?></strong></small>
        </address>
    </div>
</div>

<section class="content invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12 invoice-header">
            <h3>
            <small class="pull-left"><i class="fa fa-globe"></i> <?=$customerInfo['quotation_code'] ?></small>
            <small class="pull-right"><i class="fa fa-calendar"></i> Date Issue: <?= date('m-d-Y', strtotime($customerInfo['date_issue']) ) ?></small>
            </h3>
        </div>
        <!-- /.col -->
    </div>
  
    <!-- info row -->
    <div  style="margin: 0 auto;" class="row invoice-info">

        <div class="col-sm-4 invoice-col">
        <br/>
            <address style="text-align: left;">
                <!-- <strong>Invoice #: <?= $invoiceNo ?></strong> -->
                <strong>Customer Name: <?= $customerInfo['fullname'] ?></strong>
                <br><small><b>Address:</b> <?= $customerInfo['customerAddress'] ?></small>
                <br><small><b>Race:</b> <?= $customerInfo['race'] ?></small>
                <br><small><b>E-mail:</b> <?= $customerInfo['email'] ?></small>
                <br><small><b>Phone #:</b> <?= $customerInfo['hanphone_no'] ?> / <b>Office #:</b> <?= $customerInfo['office_no'] ?></small>
                <!-- <br>Email: jon@ironadmin.com -->
            </address>
        </div>
        <!-- /.col -->

        <div class="col-sm-4 invoice-col"></div>

        <div class="col-sm-4 invoice-col">
        <br/>
            <address style="text-align: right;">
                <!-- <strong>Invoice #: <?= $invoiceNo ?></strong> -->
                <strong>Car Plate #: <?= $customerInfo['carplate'] ?></strong>
                <br><small><b>make:</b> <?= $customerInfo['make'] ?></small>
                <br><small><b>model:</b> <?= $customerInfo['model'] ?></small>
                <!-- <br>Email: jon@ironadmin.com -->
            </address>
        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->
    

    <!-- Table row -->
    <input type="checkbox" class="showPrices" id="showPrices" checked="checked" value="" /> <b> Show Prices? </b>
    <div id="selectedServicesParts" class="row">
        <div class="col-xs-12 table">
            <table id="selecteditems" class="table table-boardered">
                <thead>
                    <tr class="qpreviewth">
                        <th class="qtblalign_center"><i class="fa fa-cogs"></i> Parts & Services</th>
                        <th class="qtblalign_center"><i class="fa fa-database"></i> Qty</th>
                        <th class="qtblalign_center"><i class="fa fa-dollar"></i> Selling Price</th>
                        <th class="qtblalign_center"><i class="fa fa-money"></i> Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($services as $sRow): ?>
                        <tr >
                            <td class="qtblalign_center"><?php echo $sRow['service_name']; ?></td>
                            <td class="qtblalign_center"><?php echo $sRow['quantity']; ?></td>
                            <td class="qtblalign_center"><?php echo $sRow['selling_price']; ?></td>
                            <td class="qtblalign_center"><?php echo $sRow['subTotal']; ?></td>
                        </tr>
                    <?php endforeach; ?>  
                    <?php foreach($parts as $pRow): ?>
                        <tr>
                            <td class="qtblalign_center"><?php echo $pRow['product_name']; ?></td>
                            <td class="qtblalign_center"><?php echo $pRow['quantity']; ?></td>
                            <td class="qtblalign_center"><?php echo $pRow['selling_price']; ?></td>
                            <td class="qtblalign_center"><?php echo $pRow['subTotal']; ?></td>
                        </tr>
                    <?php endforeach; ?> 
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div style="margin: 0 auto;" id="paymentMethod" class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            <p style="font-size: 14px; font-weight: bold;" class="lead"><i class="fa fa-tasks"></i> Remarks.</p>
            <p class="text-muted well well-sm no-shadow quoPreviewRemarks" >
                - <?= $customerInfo['remarks'] ?>
            </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <p style="font-size: 14px; font-weight: bold;" class="lead"><i class="fa fa-calculator"></i> Amount Due.</p>
            <div class="table-responsive">
                <table style="border: 1px solid #eee;" class="table ">
                    <tbody>
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>$<?= $getSubTotal ?></td>
                        </tr>
                        <tr>
                            <th>Gst(7%):</th>
                            <td>$<?= $gst ?></td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>$<?= $customerInfo['grand_total'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <hr/>
    <div class="row no-print">
        <div class="col-xs-12">

            <button class="btn btn-default pull-right" onclick="quotationPrint()"><i class="fa fa-print"></i> Print Quotation</button>

        </div>
    </div>
</section>
</div>

</div>

</div>

</div>
<br/>


    
