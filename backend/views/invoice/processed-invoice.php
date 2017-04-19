<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;

$getGst = Gst::find()->where(['branch_id' => $customerInfo['BranchId'] ])->one();

if( isset($getGst->gst) ) {
    $grandTotal = $customerInfo['grand_total'];
    $gstTotal = 100 + $getGst->gst;
    $gstTotal1 = 100 / $gstTotal;
    $gstTotal2 = $grandTotal * $gstTotal1;
    $gstFinalTotal = $grandTotal - $gstTotal2;

    $getSubTotal = $grandTotal - $gstFinalTotal;
    $gst = $getSubTotal * $getGst->gst;
    $gst = $gst / 100;

}else{
    $gst = 0.00;
    $getSubTotal = $customerInfo['grand_total'];
}

$dateIssue = date('m-d-Y', strtotime($customerInfo['date_issue']) );

$this->title = 'View Quotation';


?>

<div class="row ">

<div class="col-md-12">
<br/>

    <div class="x_panel invoiceViewContainer">

        <div class="x_title">
            <h2> Invoice Details.</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li class="dropdown"></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>

    <div class="x_content">

    <section class="content invoice">


        <!-- branch info row -->
        <div class="row">
            
            <div class="col-md-12 invoice-col">
            <br/>
                <address class="branchRowContainer">
                    <h4><b><?= strtoupper($customerInfo['name']) ?></b></h4>
                    <?= $customerInfo['address'] ?>
                    <br><b>Contact #:</b>  <?= $customerInfo['branchNumber'] ?>
                    <br><b>Prepared By:</b> <?= $customerInfo['salesPerson'] ?>
                </address>
            </div>
        </div>
        <!-- /.row -->
 

        <!-- code and date row -->
        <div class="row">
            <div class="col-xs-12 invoice-header">
                <h3>
                <small class="pull-left"><i class="fa fa-globe"></i> <?=$customerInfo['invoice_no'] ?></small>
                <small class="pull-right"><i class="fa fa-calendar"></i> Date Issue: <?= $dateIssue ?></small>
                </h3>
            </div>
        </div>
        <br/>
        <!-- /.row -->
 

        <!-- customer info row -->
        <div class="row invoice-info customerRowWrapper">
            
            <div class="col-sm-12 invoice-col">
            <br/>
                <address class="customerRowContainer" >
                    <b>Customer Name:</b> <?= $customerInfo['fullname'] ?>
                    <br><b>Address:</b> <?= $customerInfo['customerAddress'] ?>
                    <br><b>Phone:</b> <?= $customerInfo['hanphone_no'] ?> / <b>Office #</b> <?= $customerInfo['office_no'] ?>
                    <br><b>CarPlate:</b> <?= $customerInfo['carplate'] ?>
                    <br><b>Model:</b> <?= $customerInfo['carplate'] ?>
                </address>
            </div>
        </div>
        <br/>
        <!-- /.row -->
        

        <!-- Services and Parts Info row -->
        <div id="selectedServicesParts" class="row">
            <div class="col-xs-12 table">
                <table id="selecteditems" class="table table-hover">
                    <thead>
                        <tr class="qpreviewth">
                            <th class="servicespartsContainerHeader" > Description </th>
                            <th class="servicespartsContainerHeader" > Qty </th>
                            <th class="servicespartsContainerHeader" > Unit Price </th>
                            <th class="servicespartsContainerHeader" > Line Total w/o GST </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($services as $sRow): ?>
                            <tr >
                                <td class="servicespartsLists" >
                                    <?php if( $sRow['task'] == 1 ): ?> 
                                         <a href="#" style="color: red;" data-toggle="tooltip" data-placement="top" title="Pending Service" >
                                            <?php echo '*' .$sRow['service_name']; ?>
                                         </a>
                                    <?php else: ?>
                                        <?php echo $sRow['service_name']; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="servicespartsLists" ><?php echo $sRow['quantity']; ?></td>
                                <td class="servicespartsLists" >$ <?php echo number_format($sRow['selling_price'],2); ?></td>
                                <td class="servicespartsLists" >$ <?php echo number_format($sRow['subTotal'],2); ?></td>
                            </tr>
                        <?php endforeach; ?>  
                        <?php foreach($parts as $pRow): ?>
                            <tr>
                                <td class="servicespartsLists" ><?php echo $pRow['product_name']; ?></td>
                                <td class="servicespartsLists" ><?php echo $pRow['quantity']; ?></td>
                                <td class="servicespartsLists" >$ <?php echo number_format($pRow['selling_price'],2); ?></td>
                                <td class="servicespartsLists" >$ <?php echo number_format($pRow['subTotal'],2); ?></td>
                            </tr>
                        <?php endforeach; ?> 
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.row -->


        <!-- Remarks and Amount Due Info row -->
        <div id="paymentMethod" class="row remarksamountdueWrapper">
            <div class="col-xs-6">
            <br>
                <p class="lead remarksamountdueHeader"><i class="fa fa-tasks"></i> Remarks.</p>
                <p class="text-muted well well-sm no-shadow quoPreviewRemarks remarksContent" >
                    - <?= $customerInfo['remarks'] ?>
                </p>
            </div>
        
            <div class="col-xs-6 amountdueContainer">
            <br/>
                <p class="lead remarksamountdueHeader"><i class="fa fa-calculator"></i> Amount Due.</p>
                <div class="table-responsive">
                    <table class="table amountdueTbl">
                        <tbody>
                            <tr>
                                <th style="width:50%;" class="amountdueTh" >Sub-Total </th>
                                <td class="amountdueTd" >$ <?= number_format($getSubTotal,2) ?></td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" >GST(7.00%) </th>
                                <td class="amountdueTd" > <?= number_format($gst,2) ?></td>
                            </tr>
                            <tr>
                                <th class="amountdueTh" >Nett Total </th>
                                <td class="amountdueTd" >$ <?= number_format($customerInfo['grand_total'],2) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->


        <!-- this row will not appear when printing -->
        <hr/>
        <div class="row no-print">
            <div class="col-xs-12">
                <?php if( $customerInfo['paid_type'] == 1 ): ?>
                    <a href="?r=invoice/print-invoice&id=<?= $customerInfo['id'] ?>&invoice_no=<?= $customerInfo['invoice_no'] ?>"><button class="form-btn btn btn-default pull-right" ><i class="fa fa-print"></i> Print Invoice </button></a>
                <?php else: ?>
                    <a href="?r=invoice/print-multiple-invoice&id=<?= $customerInfo['id'] ?>&invoice_no=<?= $customerInfo['invoice_no'] ?>"><button class="form-btn btn btn-default pull-right" ><i class="fa fa-print"></i> Print Invoice </button></a>
                <?php endif; ?>
            </div>
        </div>

    </section>

    </div>

</div>

</div>

</div>
<br/>


    
