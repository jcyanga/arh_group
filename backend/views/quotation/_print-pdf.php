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

<div class="invoice-box">
    
    <table border="1" cellpadding="0" cellspacing="0">
        
        <tr class="top">
            <td>
                <table>

                    <tr>
                        <td class="title">
                           <b><?= $customerInfo['quotation_code'] ?></b><br>
                            <b>Date Issue: <?= date('m-d-Y', strtotime($customerInfo['date_issue']) ) ?></b>
                        </td>

                    </tr>

                </table>
            </td>

            <td></td>

            <td>
                <table>

                    <tr>
                        <td>
                            <b><?= strtoupper($customerInfo['name']) ?></b><br/>
                            <small><b><?= $customerInfo['address'] ?></b></small><br/>
                            <small><b>Contact #:</b> <?= $customerInfo['branchNumber'] ?></small><br/>
                            <small><b>Prepared By:</b> <?= $customerInfo['salesPerson'] ?></small>
                        </td>

                    </tr>

                </table>
            </td>
        </tr>

        <tr>
            <td><br/></td>
            <td><br/></td>
            <td><br/></td>
            <td><br/></td>
        </tr>
        <tr>
            <td><br/></td>
            <td><br/></td>
            <td><br/></td>
            <td><br/></td>
        </tr>

        <tr class="information">
            <td colspan="2">

                <table>
                    <tr>
                        <td>
                            Customer Name: <?= $customerInfo['fullname'] ?><br/>
                            Address: <?= $customerInfo['customerAddress'] ?><br/>
                            Phone <?= $customerInfo['hanphone_no'] ?> / Office #> <?= $customerInfo['office_no'] ?><br/>
                            CarPlate: <?= $customerInfo['carplate'] ?><br/>
                            Model: <?= $customerInfo['carplate'] ?>
                        </td>
                        
                        <td>
                           
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        
        <tr class="heading">
            <td>
                Payment Method
            </td>
            
            <td>
                Check #
            </td>
        </tr>
        
        <tr class="details">
            <td>
                Check
            </td>
            
            <td>
                1000
            </td>
        </tr>
        
        <tr class="heading">
            <th class="servicespartsContainerHeader" ><i class="fa fa-cogs"></i> Parts & Services</th>
            <th class="servicespartsContainerHeader" ><i class="fa fa-database"></i> Qty</th>
            <th class="servicespartsContainerHeader" ><i class="fa fa-dollar"></i> Selling Price</th>
            <th class="servicespartsContainerHeader" ><i class="fa fa-money"></i> Subtotal</th>
        </tr>

        <?php foreach($services as $sRow): ?>
            <tr class="item">
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

       
        <tr class="total">
            <td></td>
            
            <td>
               Total: $385.00
            </td>
        </tr>

    </table>

</div>

<div class="book">
    
    <div class="page">
        
        <div class="subpage">      

            <div class="x_panel">

                <div class="x_title">
                    
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                <!-- branch info row -->
                <div class="row printquotationBranchContainer">
                    <div class="col-md-6">
                        <div>
                            <address>
                                
                            </address>
                        </div>
                    </div>              
                </div>
                <!-- /.row -->

                <section class="content invoice">

                    <!-- quotation code info row -->
                    <div class="row">
                        <div class="col-xs-12 invoice-header">
                            <h4><small class="pull-right"></h4>
                        </div>
                    </div>
                    <br/>
                    <!-- /.row -->


                    <!-- customer info row -->
                    <div class="row invoice-info customerRowWrapper">    
                        <div class="col-sm-12 invoice-col">
                        <br/>
                            <address class="customerRowContainer" >
                                
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
                                            <td class="amountdueTd" >$<?= $gst.'.00' ?></td>
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

                </section>

                </div>

            </div>

        </div>    
    </div>
</div>

   





    
