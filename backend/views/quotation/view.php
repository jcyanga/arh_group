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

<div class="row ">

<div class="col-md-12">
<br/>

<div style="max-width: 75%; box-shadow: .7px .7px .7px .7px;" class="x_panel">

    <div class="x_title">
        <h2> Quotation Details.</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li class="dropdown"></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
    </div>

<div class="x_content">

<section class="content invoice">

    <!-- info row -->
    <div class="row">
        
        <div class="col-md-12 invoice-col">
        <br/>
            <address style="text-align: center; font-size: 12px;">
                <h4><b><?= $customerInfo['name'] ?></b></h4>
                <?= $customerInfo['address'] ?>
                <br><b>Contact #:</b>  <?= $customerInfo['branchNumber'] ?>
                <br><b>Prepared By:</b> <?= $customerInfo['salesPerson'] ?>
            </address>
        </div>
    </div>

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
    <br/>

    <!-- info row -->
    <div  style="border: solid .5px #73879C; margin: 0 auto; font-size: 11px; font-family: tahoma;" class="row invoice-info">
        
        <div class="col-sm-12 invoice-col">
        <br/>
            <address style="text-transform: uppercase; padding-left: 5px;">
                <!-- <strong>Invoice #: <?= $invoiceNo ?></strong> -->
                <b>Customer Name:</b> <?= $customerInfo['fullname'] ?>
                <br><b>Address:</b> <?= $customerInfo['customerAddress'] ?>
                <br><b>E-mail:</b> 
                <br><b>Phone:</b> <?= $customerInfo['hanphone_no'] ?> / Office # <?= $customerInfo['office_no'] ?>
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
    <div id="selectedServicesParts" class="row">
        <div class="col-xs-12 table">
            <table id="selecteditems" class="table table-hover">
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
                        <tr>
                            <td class="qtblalign_center">
                                <?php if( $sRow['task'] == 1 ): ?> 
                                     <span class="actionTooltip"><?php echo '*' .$sRow['service_name']; ?><span class="actionTooltiptext">Pending Sevice.</span></span>
                                <?php else: ?>
                                    <?php echo $sRow['service_name']; ?>
                                <?php endif; ?>
                            </td>
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

    <!-- this row will not appear when printing -->
    <hr/>
    <div class="row no-print">
        <div class="col-xs-12">
            
            <?php if( empty($getInvoice) ): ?>
            <a href="?r=quotation/update&id=<?= $customerInfo['id'] ?>"><button class="form-btn btn btn-info"><i class="fa fa-edit"></i> Update Quotation</button></a>
            <?php endif; ?>
            
            <a href="?r=quotation/delete-column&id=<?= $customerInfo['id'] ?>" onclick="return deleteConfirmation()"><button class="form-btn btn btn-danger"><i class="fa fa-trash"></i> Delete Quotation</button></a>
            
            <button class="form-btn btn btn-default pull-right" onclick="window.print();"><i class="fa fa-print"></i> Print Quotation</button>
            
            <?php if( empty($getInvoice) ): ?>
            <a href="?r=quotation/insert-invoice&id=<?= $customerInfo['id'] ?>"><button class="form-btn btn btn-success pull-right"><i class="fa fa-credit-card"></i> Generate Invoice</button></a>
            <?php endif; ?>

        </div>
    </div>
</section>
</div>

</div>

</div>

</div>
<br/>


    
