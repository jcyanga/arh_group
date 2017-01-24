<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;

$getGst = Gst::find()->where(['branch_id' => $customerInfo['branch_id'] ])->one();

if( isset($getGst->gst) ) {
    $gst = $getGst->gst;
    $getSubTotal = $customerInfo['grand_total'] / $gst;
}else{
    $gst = 0.00;
    $getSubTotal = $customerInfo['grand_total'];
}

$id = Yii::$app->request->get('id');

$this->title = 'Print Invoice';

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
                <div class="row printinvoiceBranchContainer">
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
                            <h4><small class="pull-right"><i class="fa fa-globe"></i> <?= $customerInfo['invoice_no'] ?></small></h4>
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
                                            <td class="servicespartsLists" ><?php echo '$'.$sRow['selling_price'].'.00'; ?></td>
                                            <td class="servicespartsLists" ><?php echo $sRow['subTotal']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>  
                                    <?php foreach($parts as $pRow): ?>
                                        <tr>
                                            <td class="servicespartsLists" ><?php echo $pRow['product_name']; ?></td>
                                            <td class="servicespartsLists" ><?php echo $pRow['quantity']; ?></td>
                                            <td class="servicespartsLists" ><?php echo '$'.$pRow['selling_price'].'.00'; ?></td>
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
                                            <td class="amountdueTd" >$<?= $getSubTotal.'.00' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="amountdueTh" >Gst(7%):</th>
                                            <td class="amountdueTd" >$<?= $gst ?></td>
                                        </tr>
                                        <tr>
                                            <th class="amountdueTh" >Total:</th>
                                            <td class="amountdueTd" >$<?= $customerInfo['grand_total'].'.00' ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

                    <!-- Payment History Info Row  -->
                    <h5><i class="fa fa-history"></i> Payment History</h5>
                    <div id="paymentMethod" class="row remarkspaymentsWrapper">
                        <div class="col-xs-6">
                        <br>
                            <p class="lead remarksamountdueHeader"><i class="fa fa-comments"></i> Remarks.</p>
                            <p class="text-muted well well-sm no-shadow quoPreviewRemarks remarksContent" >
                                - <?= $customerInfo['paymentRemarks'] ?>
                            </p>
                        </div>
                   
                    <div class="col-xs-6 paymentsContainer">
                        <br/>
                            <p class="lead remarksamountdueHeader"><i class="fa fa-money"></i> Amount Pay.</p>
                            <div class="table-responsive">
                                <table class="table paymentsTbl">
                                    <tbody>
                                        <tr>
                                            <th style="width:50%;"" class="amountdueTh" >Discount:</th>
                                            <td class="amountdueTd" >$<?= $customerInfo['discount'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="amountdueTh" >Total Amount:</th>
                                            <td class="amountdueTd" >$<?= $customerInfo['amount'] ?></td>
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

            <!-- Print Buttons --> 
            <div class="row">
                <div class="col-xs-12">
                    <div style="text-align: center">
                        <button class="form-btn btn btn-info btn-xs print-buttons" id="print_invoice" onclick="invoicePrint()"><i class="fa fa-print"></i> Print Invoice</button>
                        <a href="?r=invoice/invoice-export-pdf&id=<?= $id ?>&invoice_no=<?= $customerInfo['invoice_no'] ?>">
                            <button class="form-btn btn btn-danger btn-xs print-buttons" id="download_pdf"><i class="fa fa-close"></i> Close</button>
                        </a>
                    </div>
                </div>
            </div>

        </div>    
    </div>
</div>
