<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;
use common\models\PaymentType;

$getGst = Gst::find()->where(['branch_id' => $customerInfo['BranchId'] ])->one();
$dataPaymentType = PaymentType::find()->all();

if( isset($getGst->gst) ) {
    $gst = $getGst->gst;
    $getSubTotal = $customerInfo['grand_total'] / $gst;
}else{
    $gst = 0.00;
    $getSubTotal = $customerInfo['grand_total'];
}

$this->title = 'View Quotation';

$datetime = date('M-d-Y') . ' ' . date('H:i:s');

$dateIssue = date('m-d-Y', strtotime($customerInfo['date_issue']) );

?>

<div class="row form-container">

<div class="col-md-6">
<br/>

<?php $form = ActiveForm::begin(['action' => '?r=invoice/save-payment', 'method' => 'post', 'id' => 'demo-form2', 'class' => 'form-inline']); ?>
    <div class="">
        
        <div class="x_title">
            <h2> Payment Method. </h2>
            <ul class="nav navbar-right panel_toolbox"></ul>
            <div class="clearfix"></div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-12">

                <span class="pmLabel" ><i class="fa fa-question-circle"></i> PAYMENT METHOD </span>
                <br/>
                <select class="select3_single" id="getpaymentMethod" name="Payment[payment_method]" >
                    <option value='0'>CHOOSE PAYMENT METHOD HERE.</option>   
                    <option value='1'>SINGLE PAYMENT</option>             
                    <option value='2'>MULTIPLE PAYMENT</option>
                </select>
            </div>
        </div>
        <br/>

        <div class="paymentContainer" id="singleMethod">
        <div class="paymentContainerHeader">
            <div class="paymentContainerHeaderLabel">
                
                <div>
                <br/>
                    <span style="font-weight: 600;"><i class="fa fa-mail-reply"></i> Single Payment</span>
                </div>
            </div>

        </div>
        <br/>

            <div class="row transactionFormAlign" >
                
                <div class="col-md-6">
                    <span class="pmLabel" > MODE OF PAYMENT </span>   

                    <select  name="Payment[payment_type]" style="width: 100%;" class="form_pm form-control select3_single" >
                        <option value="0">CHOOSE PAYMENT HERE.</option>
                        <?php foreach($dataPaymentType as $ptRow): ?>
                            <option value="<?php echo $ptRow['id']; ?>"><?php echo $ptRow['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">

                    <span class="pmLabel" > Date & Time </span>   
                    <br/>

                    <input type="text" value="<?= $datetime ?>" class="form-control form_pmInput" name="datetime" readonly/>
                </div>

            </div>
            <br/>

            <div  class="row transactionFormAlign">

                <div class="col-md-6">
                    <span class="pmLabel" > AMOUNT </span>

                    <input type="text" name="Payment[amount]" class="form_pm form-control" placeholder="Enter Amount here." />
                </div>

                <div class="col-md-6">
                    <span class="pmLabel" > DISCOUNT </span>

                    <input type="text" name="Payment[discount]" class="form_pm form-control" placeholder="Enter Discount here." />
                </div>
            
            </div>
            <br/>

            <div  class="row transactionFormAlign">

                <div class="col-md-6">
                    <span class="pmLabel" > POINTS EARNED </span>

                    <input type="text" name="Payment[points_earned]" class="form_pm form-control" placeholder="Enter Points Earned here." />
                </div>

            </div>
            <br/>

            <div  class="row transactionFormAlign">

                <div class="col-md-6">
                    <input type="checkbox" class="chkboxRedeemPoints" id="chkboxRedeemPoints" > <b>Redeem Points?</b>
                    <br/>
                    <input type="text" class="form_pm form-control" id="sRedeemPoints" name="Payment[points_redeem]" placeholder="<?= $customerInfo['points'] ?> Points remaining." />
                </div>

            </div>
            <br/>

            <div  class="row transactionFormAlign">

                <div class="col-md-11">
                    <span class="pmLabel" > REMARKS </span>

                    <textarea cols="20" rows="3" name="Payment[remarks]" class="form_pmTxtArea form-control" placeholder="Write Remarks here."></textarea>
                </div>

            </div>
            <hr/>

            <div>
                <input type="hidden" name="Payment[invoice_id]" class="form_pm form-control" value="<?= $customerInfo['id'] ?>" />
                <input type="hidden" name="Payment[invoice_no]" class="form_pm form-control" value="<?= $customerInfo['invoice_no'] ?>" />
                <input type="hidden" name="Payment[customer_id]" class="form_pm form-control" value="<?= $customerInfo['customer_id'] ?>" />
                <input type="hidden" name="Payment[payment_date]" class="form_pm form-control" value="<?php echo date('Y-m-d'); ?>" />
                <input type="hidden" name="Payment[payment_time]" class="form_pm form-control" value="<?php echo date('H:i:s'); ?>" />
            </div>

            <div class="row">

            <div class="col-md-12">
                <div style="text-align: right;">        
                <?= Html::submitButton('<li class=\'fa fa-save\'></li> Submit Payment' , ['class' =>'form-btn btn btn-dark']) ?>
                </div>
            </div>

            </div>
            <br/>

        </div>
        <br/>
        
        <div class="paymentContainer" id="multipleMethod">
        <div class="paymentContainerHeader">
            <div class="paymentContainerHeaderLabel">
                
                <div>
                <br/>
                    <span style="font-weight: 600;"><i class="fa fa-mail-reply-all"></i> Multiple Payment</span>
                </div>
            </div>
            
        </div>
        <br/>

            <div  class="row transactionFormAlign">

                <div class="col-md-6">
                    <span class="pmLabel" > MODE OF PAYMENT </span>   

                    <select  name="Payment[mPayment_type]" style="width: 100%;" class="form_pm form-control select3_single" id="mPayment_type" >
                        <option value="0">CHOOSE PAYMENT HERE.</option>
                        <?php foreach($dataPaymentType as $ptRow): ?>
                            <option value="<?php echo $ptRow['id']; ?>"><?php echo $ptRow['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <span class="pmLabel" > Date & Time </span>   
                    <br/>

                    <input type="text" value="<?= $datetime ?>" class="form-control form_pmInput" name="datetime" readonly/>
                </div>

            </div>
            <br/>

            <div class="row transactionFormAlign">

                <div class="col-md-6">
                    <span class="pmLabel" > AMOUNT </span>

                    <input type="text" name="Payment[mAmount]" class="form_pm form-control" id="mAmount" placeholder="Enter Amount here." />
                </div>

                <div class="col-md-6">
                    <span class="pmLabel" > DISCOUNT </span>

                    <input type="text" name="Payment[mDiscount]" class="form_pm form-control" id="mDiscount" placeholder="Enter Discount here." />
                </div>
            
            </div>
            <br/>

            <div  class="row transactionFormAlign">
                <div class="col-md-6">
                    <span class="pmLabel" > POINTS EARNED </span>

                    <input type="text" name="Payment[mPoints_earned]" class="form_pm form-control" id="mPoints_earned" placeholder="Enter Points Earned here." />
                </div>

            </div>
            <br/>  
               
            <div  class="row transactionFormAlign">

                <div class="col-md-6">
                    <input type="checkbox" class="mChkboxRedeemPoints" id="mChkboxRedeemPoints" > <b>Redeem Points?</b>
                    <br/>
                    <input type="text" class="form_pm form-control" id="mRedeemPoints" name="Payment[mPoints_redeem]" placeholder="<?= $customerInfo['points'] ?> Points remaining." />
                </div>

            </div>
            <br/>

            <div  class="row transactionFormAlign">

                <div class="col-md-11">
                    <span class="pmLabel" > REMARKS </span>

                    <textarea cols="20" rows="3" name="Payment[mRemarks]" class="form_pmTxtArea form-control" id="mRemarks" placeholder="Write Remarks here."></textarea>
                </div>

            </div>

            <div  class="row transactionFormAlign">

                <div class="col-md-12">
                    <div style="text-align: right;">
                        <button type="button" class="form-btn btn btn-link" onclick="newPayment()"><span class="pmLabel" > - ADD PAYMENT <i class="fa fa-shopping-cart"></i></span></button>
                    </div>
                </div>

            </div>

            <div class="added-payment-lists" id="added-payment-lists"></div>

            <div>
                <input type="hidden" id="n" value="0">
                <input type="hidden" name="Payment[mInvoice_id]" id="mInvoice_id" class="form_pm form-control" value="<?= $customerInfo['id'] ?>" />
                <input type="hidden" name="Payment[mInvoice_no]" id="mInvoice_no" class="form_pm form-control" value="<?= $customerInfo['invoice_no'] ?>" />
                <input type="hidden" name="Payment[mCustomer_id]" id="mCustomer_id" class="form_pm form-control" value="<?= $customerInfo['customer_id'] ?>" />
                <input type="hidden" name="Payment[mPayment_date]" id="mPayment_date" class="form_pm form-control" value="<?php echo date('Y-m-d'); ?>" />
                <input type="hidden" name="Payment[mPayment_time]" id="mPayment_time" class="form_pm form-control" value="<?php echo date('H:i:s'); ?>" />
            </div>


            <div class="row">

            <div class="col-md-12">
                <div style="text-align: right;">        
                <?= Html::submitButton('<li class=\'fa fa-save\'></li> Submit Payment' , ['class' =>'form-btn btn btn-dark']) ?>
                </div>
            </div>

            </div>
            <br/>

    </div>
    <br/>

</div>

<?php ActiveForm::end(); ?>

</div> 

<div class="col-md-6">
<br/>

    <div class="x_panel invoicePaymentViewContainer">

        <div class="x_title">
            <h2> Invoice #<?= $customerInfo['id'] ?></h2>
            <ul class="nav navbar-right panel_toolbox"></ul>
            <div class="clearfix"></div>
        </div>

    <div class="x_content">

    <section class="content invoice">


        <!-- branch info row -->
        <div class="row">
            
            <div class="col-md-12 invoice-col">
            <br/>
                <address class="branchRowContainer">
                    <h4><b><i class="fa fa-car"></i> <?= strtoupper($customerInfo['name']) ?></b></h4>
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
                <h4>
                <small class="pull-left"><i class="fa fa-globe"></i> Invoice: <?=$customerInfo['invoice_no'] ?></small>
                <small class="pull-right"><i class="fa fa-calendar"></i> Date Issue: <?= $dateIssue ?></small>
                </h4>
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

    </section>

    </div>

</div>

</div>

</div>
<br/>


    
