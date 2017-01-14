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
        
        <div class="subpage">
          

<div class="x_panel">

    <div class="x_title">
        <small style=" font-size: 12px;" class="pull-right"><i class="fa fa-calendar"></i> Date Issue: <?= date('m-d-Y', strtotime($customerInfo['date_issue']) ) ?></small>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

    <!-- info row -->
    <div  style="margin: 0 auto;" class="row ">

        <div class="col-md-4">
            <div style=" font-size: 13px;">
                <address>
                    <strong><?= $customerInfo['name'] ?></strong>
                    <br><small><?= $customerInfo['address'] ?></small>
                    <br><small>Contact No.  <?= $customerInfo['branchNumber'] ?></small>
                    <br><small><strong>Prepared By: <?= $customerInfo['salesPerson'] ?></strong></small>
                </address>
            </div>
        </div>
      
    </div>

    <section class="content invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12 invoice-header">
                <h4><small class="pull-right"><i class="fa fa-globe"></i> <?=$customerInfo['quotation_code'] ?></small></h4>
            </div>
            <!-- /.col -->
        </div>
        <br/>

        <!-- info row -->
        <div  style="border: solid .5px #73879C; margin: 0 auto; font-size: 11px; font-family: tahoma;" class="row invoice-info">
            
            <div class="col-sm-12 invoice-col">
            <br/>
                <address style="text-transform: uppercase; padding-left: 5px;">
                    <!-- <strong>Invoice #: <?= $invoiceNo ?></strong> -->
                    <b>Customer Name:</b> <?= $customerInfo['fullname'] ?>
                    <br><b>Address:</b> <?= $customerInfo['customerAddress'] ?>
                    <br><b>Phone:</b> <?= $customerInfo['hanphone_no'] ?> / <b>Office #</b> <?= $customerInfo['office_no'] ?>
                    <br><b>CarPlate:</b> <?= $customerInfo['carplate'] ?>
                    <br><b>Model:</b> <?= $customerInfo['carplate'] ?>
                    <!-- <br>Email: jon@ironadmin.com -->
                </address>
            </div>
            <!-- /.col -->
        </div>
        <br/>
        <!-- /.row -->
        

        <!-- Table row -->
        <div id="showPrices">
            <input type="checkbox" class="showPrices" checked="checked" value="" /> <b style="font-size: 12px;"> Show Prices? </b>
        </div>
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

        <div style="margin: 0 auto; border: solid .5px #73879C;" id="paymentMethod" class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
            <br>
                <p style="font-size: 13px; font-weight: bold;" class="lead"><i class="fa fa-tasks"></i> Remarks.</p>
                <p  style="font-size: 11.5px; " class="text-muted well well-sm no-shadow quoPreviewRemarks" >
                    - <?= $customerInfo['remarks'] ?>
                </p>
            </div>
            <!-- /.col -->
            <div style="border-left: solid .5px #73879C;" class="col-xs-6">
            <br/>
                <p  style="font-size: 13px; font-weight: bold;" class="lead"><i class="fa fa-calculator"></i> Amount Due.</p>
                <div class="table-responsive">
                    <table style="border: 1px solid #eee;" class="table ">
                        <tbody>
                            <tr>
                                <th style="width:50%; font-size: 12px;">Subtotal:</th>
                                <td style="font-size: 11.5px;">$<?= $getSubTotal ?></td>
                            </tr>
                            <tr>
                                <th  style="font-size: 12px;">Gst(7%):</th>
                                <td style="font-size: 11.5px;">$<?= $gst ?></td>
                            </tr>
                            <tr>
                                <th  style="font-size: 12px;">Total:</th>
                                <td style="font-size: 11.5px;">$<?= $customerInfo['grand_total'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    </div>

    </div>

<!-- this row will not appear when printing -->
   
            <div class="row">
                <div class="col-xs-12">
                    <div style="text-align: center">
                        <button class="form-btn btn btn-danger btn-xs " style="width: 250px;" id="download_pdf"><i class="fa fa-download"></i> Download to PDF</button>
                        <button class="form-btn btn btn-warning btn-xs " style="width: 250px;" id="print_quotation" onclick="quotationPrint()"><i class="fa fa-print"></i> Print Quotation</button>
                    </div>
                </div>
            </div>

        </div>    
    </div>
</div>

   





    
