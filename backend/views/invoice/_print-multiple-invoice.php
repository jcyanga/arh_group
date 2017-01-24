<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;

$this->title = 'Print Multiple Invoice';

?>

<div class="book">
    
    <?php foreach( $multipleInvoiceInfo as $iRow): ?>
        
        <div class="page">
        
                <div class="subpage">
                    
                    <div class="x_panel">

                        <div class="x_title">
                            <small class="pull-right printquotationDate"><i class="fa fa-calendar"></i> Date Issue: <?= date('m-d-Y', strtotime($iRow['date_issue']) ) ?></small>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                        <!-- branch info row -->
                        <div class="row printinvoiceBranchContainer">
                            <div class="col-md-6">
                                <div>
                                    <address>
                                        <h5><b><?= strtoupper($iRow['name']) ?></b></h5>
                                        <?= $iRow['address'] ?>
                                        <br><b>Contact #:</b>  <?= $iRow['branchNumber'] ?>
                                        <br><b>Prepared By:</b> <?= $iRow['salesPerson'] ?>
                                    </address>
                                </div>
                            </div>              
                        </div>
                        <!-- /.row -->

                        <section class="content invoice">

                        <!-- quotation code info row -->
                        <div class="row">
                            <div class="col-xs-12 invoice-header">
                                <h4><small class="pull-right"><i class="fa fa-globe"></i> <?= $iRow['invoice_no'] ?></small></h4>
                            </div>
                        </div>
                        <br/>
                        <!-- /.row -->


                        <!-- customer info row -->
                        <div class="row invoice-info customerRowWrapper">    
                            <div class="col-sm-12 invoice-col">
                            <br/>
                                <address class="customerRowContainer" >
                                    <b>Customer Name:</b> <?= $iRow['fullname'] ?>
                                    <br><b>Address:</b> <?= $iRow['customerAddress'] ?>
                                    <br><b>Phone:</b> <?= $iRow['hanphone_no'] ?> / <b>Office #</b> <?= $iRow['office_no'] ?>
                                    <br><b>CarPlate:</b> <?= $iRow['carplate'] ?>
                                    <br><b>Model:</b> <?= $iRow['carplate'] ?>
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
                                    - <?= $iRow['remarks'] ?>
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
                                                <td class="amountdueTd" >$ 2</td>
                                            </tr>
                                            <tr>
                                                <th class="amountdueTh" >Gst(7%):</th>
                                                <td class="amountdueTd" >$ 3</td>
                                            </tr>
                                            <tr>
                                                <th class="amountdueTh" >Total:</th>
                                                <td class="amountdueTd" >$ <?= $iRow['grand_total'] ?></td>
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
                                    - <?= $iRow['paymentRemarks'] ?>
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
                                                <td class="amountdueTd" >$<?= $iRow['discount'] ?></td>
                                            </tr>
                                            <tr>
                                                <th class="amountdueTh" >Total Amount:</th>
                                                <td class="amountdueTd" >$<?= $iRow['amount'] ?></td>
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

                </div>    

        </div>

    <?php endforeach; ?>

    <!-- print-buttons -->
    <div class="row">
        <div class="col-xs-12">
            <div style="text-align: center">
                <button class="form-btn btn btn-danger btn-xs print-buttons" id="download_pdf"><i class="fa fa-download"></i> Download to PDF</button>
                <button class="form-btn btn btn-warning btn-xs print-buttons" id="print_invoice" onclick="multipleInvoicePrint()"><i class="fa fa-print"></i> Print Invoice</button>
            </div>
        </div>
    </div>
    <br/><br/>

</div>
