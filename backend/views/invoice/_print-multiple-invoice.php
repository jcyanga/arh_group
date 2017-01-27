<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;
use common\models\TermsAndConditions;

$getTermsAndConditions = TermsAndConditions::find()->all();

$this->title = 'Print Multiple Invoice';

$id = Yii::$app->request->get('id');

$n = 0;
$i = 1;
?>

<?php foreach( $multipleInvoiceInfo as $iRow): ?>
    <?php
        $getGst = Gst::find()->where(['branch_id' => $iRow['branch_id'] ])->one();
            if( isset($getGst->gst) ) {
                $gst = $getGst->gst;
                $getSubTotal = $iRow['grand_total'] / $gst;
            }else{
                $gst = 0;
                $getSubTotal = $iRow['grand_total'];
            }
    ?>  

<div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="assets/bootstrap/images/arh_receipt_logo.png" style="height: 55%; width: 100%; max-width:500px;">
                                <br/>

                                <div class="row" style="text-align: left; font-size: 11px; text-transform: uppercase;">
                                    
                                    <div class="col-md-12">
                                        <b>Name : </b> <?= Html::encode($iRow['name']) ?>
                                    </div>

                                    <div style="margin-top: -20px;" class="col-md-12">
                                        <b>Billing Address : </b> <?= Html::encode($iRow['address']) ?>
                                    </div>

                                </div>

                            </td>
                            
                            <td style="width: 45%">
                                    <div class="row" style="text-align: left; font-size: 11px;">
                                     
                                     <div class="col-md-12"><b>INVOICE / CASH BILL</b></div>
                                     <br/>

                                     <div class="col-md-6">
                                         
                                         <div class="col-md-12"><b>Invoice No.</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Terms</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Date & Time In</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Date & Time Out</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Vehicle No.</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Make</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Model</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Company Tel.</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Home Tel.</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Mobile</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Mileage</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Balance Points</b></div>

                                     </div>
                                     
                                     <div class="col-md-6">
                                         
                                         <div class="col-md-12">
                                            : <?= Html::encode($iRow['invoice_no']) ?> 
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($iRow['paymenttypeName']) ?> 
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode(date('d M Y', strtotime($iRow['created_at']))) ?>
                                              <?= Html::encode(date('H:i:s', strtotime($iRow['time_created']))) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode(date('d M Y H:i:s')) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($iRow['carplate']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($iRow['make']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($iRow['model']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($iRow['office_no']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($iRow['hanphone_no']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($iRow['hanphone_no']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : 0
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($iRow['points']) ?>
                                         </div>

                                     </div>

                    
                                        
                                    </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr  class="heading">
                <table class="headers">
                <tr>
                <td class="servicespartsContainerHeader" style="width: 10%; text-align: center; font-size: 11px;" > S/No </td>
                
                <td class="servicespartsContainerHeader" style="width: 40%; text-align: center; font-size: 11px;" > Description </td>
                <td class="servicespartsContainerHeader" style="width: 10%; text-align: center; font-size: 11px;" > Unit Price</td>
                <td class="servicespartsContainerHeader" style="width: 10%; text-align: center; font-size: 11px;" > Qty</td>
                <td class="servicespartsContainerHeader" style="width: 10%; text-align: center; font-size: 11px;" > Member Discount</td>
                <td class="servicespartsContainerHeader" style="width: 10%; text-align: center; font-size: 11px;" > Additional Discount</td>
                <td class="servicespartsContainerHeader" style="width: 10%; text-align: center; font-size: 11px;" > Line Total w/o GST</td>
                </tr></table>
            </tr>

            <tr class="details">
              
                <table border="1" style="border: solid 1px #666; " cellspacing ="0" cellpadding ="0" >
                    <tbody>
                        <?php foreach($services as $sRow): ?>
                            <?php $n++; ?>
                            <tr>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" ><?php echo $n; ?></td>
                                <td class="servicespartsLists" style="width: 40%; text-align: center; font-size: 11px;" ><?php echo $sRow['service_name']; ?></td>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" ><?php echo '$ '.$sRow['selling_price'].'.00'; ?></td>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" ><?php echo $sRow['quantity']; ?></td>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" >-</td>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" >-</td>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" ><?php echo '$ '.$sRow['subTotal'].'.00'; ?></td>
                            </tr>
                        <?php endforeach; ?>  
                        <?php foreach($parts as $pRow): ?>
                            <?php $i += $n; ?>
                            <tr>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" ><?php echo $i; ?></td>
                                <td class="servicespartsLists" style="width: 40%; text-align: center; font-size: 11px;" ><?php echo $pRow['product_name']; ?></td>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" ><?php echo '$ '.$pRow['selling_price'].'.00'; ?></td>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" ><?php echo $pRow['quantity']; ?></td>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" >-</td>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" >-</td>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" ><?php echo '$ '.$pRow['subTotal'].'.00'; ?></td>
                            </tr>

                        <?php endforeach; ?> 


                    </tbody>
                </table>
                
                <table border="1" style="border: solid 1px #666; " cellspacing ="0" cellpadding ="0" >
                    <tr>
                        <td class="servicespartsLists" style="width: 90%; text-align: right"><b>Gross Total</b></td>
                        <td class="servicespartsLists" style="width: 10%; text-align: center" ><b><?php echo '$ '.$getSubTotal.'.00' ?></b></td>
                    </tr>
                    <tr>
                        <td class="servicespartsLists" style="width: 90%; text-align: right;" ><b>Membership : Reward Member Discount : 0.00%</b></td>
                        <td class="servicespartsLists" style="width: 10%; text-align: center" ><b>0.00</b></td>
                    </tr>
                    <tr>
                        <td class="servicespartsLists" style="width: 90%; text-align: right;" ><b>GST(7.00%)</b></td>
                        <td class="servicespartsLists" style="width: 10%; text-align: center" ><b><?php echo $gst; ?></b></td>
                    </tr>
                    <tr>
                        <td class="servicespartsLists" style="width: 90%; text-align: right;" ><b>Nett Total:</b></td>
                        <td class="servicespartsLists" style="width: 10%; text-align: center" ><b><?php echo '$ '.$iRow['grand_total'].'.00'; ?></b></td>
                    </tr>
                </table>
            </tr>

            <tr class="item">
                <small style="font-size: 12px;"><b>Terms and Conditions</b></small>
                <br/>
                        <?php foreach($getTermsAndConditions as $tcRow): ?>
                           
                                <span style="text-align: left; font-size: 9px;font-weight: 600;"><?php echo $tcRow['id'] . '.)'; ?> <?php echo $tcRow['descriptions']; ?></span>
                                <br/>

                        <?php endforeach; ?> 
            </tr>

            <tr class="item">
              
                <table >
                    <tbody>
                        <tr>
                            <td style="width: 30%;">
                            <hr/>
                            <h5 style="text-align: center; font-size: 11px;">Attended by</h5>
                            </td>

                            <td style="width: 30%;">
                            <hr/>
                            <h5 style="text-align: center; font-size: 11px;">Date</h5>
                            </td>

                            <td style="width: 40%;">
                            <hr/>
                            <h5 style="text-align: center; font-size: 11px;">Name, NRIC & Signature or Authorised Signature & Company Shop</h5>
                            </td>

                            
                            </td>
                        </tr>
                    </tbody>
                </table>
           
            </tr>

        </table>
</div>

<?php endforeach; ?>
<br/>

<!-- Print Buttons -->   
<div class="row">
    <div class="col-xs-12">
        <div style="text-align: center">
            <button class="form-btn btn btn-info btn-xs print-buttons" id="print_invoice" onclick="multipleInvoicePrint()"><i class="fa fa-print"></i> Print </button>
       
            <button class="form-btn btn btn-danger btn-xs print-buttons close_invoice_print" id="close_print"><i class="fa fa-close"></i> Close </button>
      
        </div>
    </div>
</div>

