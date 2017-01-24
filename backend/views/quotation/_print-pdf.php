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
    $getSubTotal = $customerInfo['grand_total'];
}

$getInvoice = Invoice::find()->where(['quotation_code' => $customerInfo['quotation_code'] ])->one();

$this->title = 'Print-PDF Quotation';

?>

<div class="book">
    
    <div class="page">
        
        <div class="subpage">      

            <div class="x_panel">

                <div class="x_title">
                    <small class="pull-right printquotationDate"><i class="fa fa-calendar"></i> Date Issue: <?= date('m-d-Y', strtotime($customerInfo['date_issue']) ) ?></small>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                <!-- branch info row -->
                <div class="row printquotationBranchContainer">
                    <div class="col-md-6">
                        <div>
                            <address>
                                <h5><b><?= strtoupper($customerInfo['name']) ?></b></h5>
                                <?= $customerInfo['address'] ?>
                                <br><b>Contact #:</b>  <?= $customerInfo['branchNumber'] ?>
                                <br><b>Prepared By:</b> <?= $customerInfo['salesPerson'] ?>
                            </address>
                        </div>
                    </div>              
                </div>
                <!-- /.row -->

                <section class="content invoice">

                    <!-- quotation code info row -->
                    <div class="row">
                        <div class="col-xs-12 invoice-header">
                            <h4><small class="pull-right"><i class="fa fa-globe"></i> <?= $customerInfo['quotation_code'] ?></small></h4>
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
                            <table id="selecteditems" class="table table-boardered">
                                <thead>
                                    <tr class="qpreviewth">
                                        <th class="servicespartsContainerHeader" ><i class="fa fa-cogs"></i> Parts & Services</th>
                                        <th class="servicespartsContainerHeader" ><i class="fa fa-database"></i> Qty</th>
                                        <th class="servicespartsContainerHeader" ><i class="fa fa-dollar"></i> Selling Price</th>
                                        <th class="servicespartsContainerHeader" ><i class="fa fa-money"></i> Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($services as $sRow): ?>
                                        <tr >
                                            <td class="servicespartsLists" ><?php echo $sRow['service_name']; ?></td>
                                            <td class="servicespartsLists" ><?php echo $sRow['quantity']; ?></td>
                                            <td class="servicespartsLists" ><?php echo $sRow['selling_price']; ?></td>
                                            <td class="servicespartsLists" ><?php echo $sRow['subTotal']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>  
                                    <?php foreach($parts as $pRow): ?>
                                        <tr>
                                            <td class="servicespartsLists" ><?php echo $pRow['product_name']; ?></td>
                                            <td class="servicespartsLists" ><?php echo $pRow['quantity']; ?></td>
                                            <td class="servicespartsLists" ><?php echo $pRow['selling_price']; ?></td>
                                            <td class="servicespartsLists" ><?php echo $pRow['subTotal']; ?></td>
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
                                            <th style="width:50%;" class="amountdueTh" >Subtotal:</th>
                                            <td class="amountdueTd" >$<?= $getSubTotal ?></td>
                                        </tr>
                                        <tr>
                                            <th class="amountdueTh" >Gst(7%):</th>
                                            <td class="amountdueTd" >$<?= $gst ?></td>
                                        </tr>
                                        <tr>
                                            <th class="amountdueTh" >Total:</th>
                                            <td class="amountdueTd" >$<?= $customerInfo['grand_total'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

                </section>

                </div>

            </div>

        </div>    
    </div>
</div>

   





    
