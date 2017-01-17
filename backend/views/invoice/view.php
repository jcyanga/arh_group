<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;

$getGst = Gst::find()->where(['branch_id' => $customerInfo['BranchId'] ])->one();

if( isset($getGst->gst) ) {
    $gst = $getGst->gst;
    $getSubTotal = $customerInfo['grand_total'] / $gst;
}else{
    $gst = 0.00;
    $getSubTotal = $customerInfo['grand_total'] / $gst;
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
                            <th class="servicespartsContainerHeader" ><i class="fa fa-cogs"></i> Parts & Services</th>
                            <th class="servicespartsContainerHeader" ><i class="fa fa-database"></i> Qty</th>
                            <th class="servicespartsContainerHeader" ><i class="fa fa-dollar"></i> Selling Price</th>
                            <th class="servicespartsContainerHeader" ><i class="fa fa-money"></i> Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($services as $sRow): ?>
                            <tr>
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

        <!-- button container -->
        <hr/>
        <div class="row no-print">
            <div class="col-xs-12">
                
                <?php if( $customerInfo['status'] <> 1 ): ?>
                    <a href="?r=invoice/payment-method&id=<?= $customerInfo['id'] ?>"><button class="form-btn btn btn-default pull-right" > Proceed to Payment <i class="fa fa-chevron-circle-right"></i></button></a>
                    
                    <a href="?r=invoice/delete-column&id=<?= $customerInfo['id'] ?>" onclick="return deleteConfirmation()"><button class="form-btn btn btn-danger pull-right"><i class="fa fa-trash"></i> Delete Invoice</button></a>
                    
                    <a href="?r=invoice/update&id=<?= $customerInfo['id'] ?>"><button class="form-btn btn btn-info pull-right"><i class="fa fa-edit"></i> Update Invoice</button></a>
                <?php endif; ?>
                    
            </div>
        </div>
        <!-- /.row -->

    </section>
    
    </div>

    </div>

</div>

</div>
<br/>


    

            

  

    
