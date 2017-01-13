<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

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


$this->title = 'View Quotation';
// $this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
$invoiceNo = 'Arh' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);


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

        <div style="border-top: solid 1px #eee;" id="singleMethod">
        <br/>

        <div style="margin-left: 10px;">
            <span > <li class="fa fa-comments-o"></li> <b>SINGLE PAYMENT METHOD</b> </span>
        </div>
        <br/>

            <div style="margin-left: 10px;" class="row">
                
                <div class="col-md-6">
                    <span class="pmLabel" ><i class="fa fa-calendar"></i> DATE & TIME OF PAYMENT </span>

                    <input type="text" value="<?php echo date('m-d-Y H:i:s'); ?>" class="form-control form_pmInput" name="datetime" readonly/>
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-bank"></i> MODE OF PAYMENT </span>   
                    <br/>

                    <select  name="Payment[payment_type]" style="width: 100%;" class="form_pm form-control select3_single" >
                        <option value="0">CHOOSE PAYMENT HERE.</option>
                        <option value="">CHOOSE PAYMENT HERE.</option>
                        <option value="Cash_Payment">Cash Payment</option>
                        <option value="Telegraphic_Transfer">Telegraphic Transfer</option>
                        <option value="Money_Orders">Money Orders</option>
                        <option value="Bill_of_Exchange">Bill of Exchange</option>
                        <option value="Promissory_Notes">Promissory Notes</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Bank_Draft">Bank Draft</option>
                    </select>
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-money"></i> AMOUNT </span>

                    <input type="text" name="Payment[amount]" class="form_pm form-control" placeholder="Enter Amount here." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-minus-square"></i> DISCOUNT </span>

                    <input type="text" name="Payment[discount]" class="form_pm form-control" placeholder="Enter Discount here." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <input type="checkbox" class="chkboxRedeemPoints" id="chkboxRedeemPoints" > <b>Redeem Points?</b>
                    <br/>
                    <input type="text" class="form_pm form-control" id="sRedeemPoints" name="Payment[points_redeem]" placeholder="<?= $customerInfo['points'] ?> Points remaining." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-dot-circle-o"></i> POINTS EARNED </span>

                    <input type="text" name="Payment[points_earned]" class="form_pm form-control" placeholder="Enter Points Earned here." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-11">
                    <span class="pmLabel" ><i class="fa fa-comments"></i> REMARKS </span>

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
                <?= Html::submitButton('<li class=\'fa fa-save\'></li> Submit Payment' , ['class' =>'form-btn btn btn-info']) ?>
                <?= Html::resetButton('<li class=\'fa fa-file\'></li> Cancel', ['class' => 'form-btn btn btn-default']) ?>
                </div>
            </div>

            </div>
            <br/>

        </div>
        
        <div style="border-top: solid 1px #eee;" id="multipleMethod">
        <br/>

        <div style="margin-left: 10px;">
            <span > <li class="fa fa-comments-o"></li> <b>MULTIPLE PAYMENT METHOD</b> </span>
        </div>
        <br/>

            <div style="margin-left: 10px;" class="row">
                
                <div class="col-md-6">
                    <span class="pmLabel" ><i class="fa fa-calendar"></i> DATE & TIME OF PAYMENT </span>

                    <input type="text" value="<?php echo date('m-d-Y H:i:s'); ?>" class="form-control form_pmInput" name="datetime" readonly/>
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-bank"></i> MODE OF PAYMENT </span>   
                    <br/>

                    <select  name="Payment[mPayment_type]" style="width: 100%;" class="form_pm form-control select3_single" id="mPayment_type" >
                        <option value="0">CHOOSE PAYMENT HERE.</option>
                        <option value="Cash_Payment">Cash Payment</option>
                        <option value="Telegraphic_Transfer">Telegraphic Transfer</option>
                        <option value="Money_Orders">Money Orders</option>
                        <option value="Bill_of_Exchange">Bill of Exchange</option>
                        <option value="Promissory_Notes">Promissory Notes</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Bank_Draft">Bank Draft</option>
                    </select>
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-money"></i> AMOUNT </span>

                    <input type="text" name="Payment[mAmount]" class="form_pm form-control" id="mAmount" placeholder="Enter Amount here." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-minus-square"></i> DISCOUNT </span>

                    <input type="text" name="Payment[mDiscount]" class="form_pm form-control" id="mDiscount" placeholder="Enter Discount here." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <input type="checkbox" class="mChkboxRedeemPoints" id="mChkboxRedeemPoints" > <b>Redeem Points?</b>
                    <br/>
                    <input type="text" class="form_pm form-control" id="mRedeemPoints" name="Payment[mPoints_redeem]" placeholder="<?= $customerInfo['points'] ?> Points remaining." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-dot-circle-o"></i> POINTS EARNED </span>

                    <input type="text" name="Payment[mPoints_earned]" class="form_pm form-control" id="mPoints_earned" placeholder="Enter Points Earned here." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-11">
                    <span class="pmLabel" ><i class="fa fa-comments"></i> REMARKS </span>

                    <textarea cols="20" rows="3" name="Payment[mRemarks]" class="form_pmTxtArea form-control" id="mRemarks" placeholder="Write Remarks here."></textarea>
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-12">
                    <div style="text-align: right;">
                        <button type="button" class="form-btn btn btn-link" onclick="newPayment()"><span class="pmLabel" ><i class="fa fa-plus-circle"></i> ADD PAYMENT </span></button>
                    </div>
                </div>

            </div>
            <hr/>

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
                <?= Html::submitButton('<li class=\'fa fa-save\'></li> Submit Payment' , ['class' =>'form-btn btn btn-info']) ?>
                <?= Html::resetButton('<li class=\'fa fa-file\'></li> Cancel', ['class' => 'form-btn btn btn-default']) ?>
                </div>
            </div>

            </div>
            <br/>

        </div>

    </div>

<?php ActiveForm::end(); ?>

</div> 

<div class="col-md-6">
<br/>

<div style=" box-shadow: .7px .7px .7px .7px;" class="x_panel">

    <div class="x_title">
        <h2> Invoice #<?= $customerInfo['id'] ?></h2>
        <ul class="nav navbar-right panel_toolbox">
            <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li class="dropdown"></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li> -->
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
            <h4>
            <small class="pull-left"><i class="fa fa-globe"></i> <?=$customerInfo['invoice_no'] ?></small>
            <small class="pull-right"><i class="fa fa-calendar"></i> Date Issue: <?= date('m-d-Y', strtotime($customerInfo['date_issue']) ) ?></small>
            </h4>
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
                        <tr>
                            <td class="qtblalign_center" <?php if( $sRow['task'] == 1 ): ?> style="color: red;" <?php endif; ?> >
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

</section>
</div>

</div>

</div>

</div>
<br/>


    
