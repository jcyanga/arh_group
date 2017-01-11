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

<div class="row form-container">

<div class="col-md-12">

<div style="border:0;" class="x_panel">

    <div class="x_title">
        <h2> Quotation Preview.</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
    </div>

<div class="x_content">

<section class="content invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12 invoice-header">
            <h1>
            <small class="pull-left"><i class="fa fa-globe"></i> <?=$customerInfo['quotation_code'] ?></small>
            <small class="pull-right"><i class="fa fa-calendar"></i> Date Issue: <?= date('m-d-Y', strtotime($customerInfo['date_issue']) ) ?></small>
            </h1>
        </div>
        <!-- /.col -->
    </div>
    <br/>

    <!-- info row -->
    <div  style="margin: 0 auto; max-width: 90%" class="row invoice-info">
        
        <div class="col-sm-4 invoice-col">
        <br/>
            <address style="text-align: center;">
                <strong>Branch Prepared: <?= $customerInfo['name'] ?></strong>
                <br><small><?= $customerInfo['address'] ?></small>
                <br><small>Contact No.  <?= $customerInfo['branchNumber'] ?></small>
                <br><small><strong>Prepared By: <?= $customerInfo['salesPerson'] ?></strong></small>
            </address>
        </div>
        <!-- /.col -->

        <div class="col-sm-4 invoice-col">
        <br/>
            <address style="text-align: center;">
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

        <div class="col-sm-4 invoice-col">
        <br/>
            <address style="text-align: center;">
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
                        <tr <?php if( $sRow['task'] == 1 ): ?> style="color: red;" <?php endif; ?> >
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

    <div style="margin: 0 auto;" id="paymentMethod" class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            <p class="lead"><i class="fa fa-tasks"></i> Remarks.</p>
            <p class="text-muted well well-sm no-shadow quoPreviewRemarks" >
                - <?= $customerInfo['remarks'] ?>
            </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
            <p class="lead"><i class="fa fa-calculator"></i> Amount Due.</p>
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
            <?php if( empty($getInvoice) ): ?>
            <a href="?r=quotation/print-quotation&id=<?= $customerInfo['id'] ?>"><button class="btn btn-info"><i class="fa fa-edit"></i> Update Quotation</button></a>
            <?php endif; ?>
            
            <a href="?r=quotation/delete-column&id=<?= $customerInfo['id'] ?>" onclick="return deleteConfirmation()"><button class="btn btn-danger"><i class="fa fa-trash"></i> Delete Quotation</button></a>
            
            <button class="btn btn-default pull-right" onclick="window.print();"><i class="fa fa-print"></i> Print Quotation</button>
            
            <?php if( empty($getInvoice) ): ?>
            <a href="?r=quotation/insert-invoice&id=<?= $customerInfo['id'] ?>"><button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Generate Invoice</button></a>
            <?php endif; ?>

        </div>
    </div>
</section>
</div>

</div>

</div>

</div>
<br/>


    
