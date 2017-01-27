<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;
use common\models\Invoice;
use common\models\TermsAndConditions;

$getGst = Gst::find()->where(['branch_id' => $customerInfo['BranchId'] ])->one();

if( isset($getGst->gst) ) {
    $gst = $getGst->gst;
    $getSubTotal = $customerInfo['grand_total'] / $gst;
}else{
    $gst = 0.00;
    $getSubTotal = $customerInfo['grand_total'];
}

$getInvoice = Invoice::find()->where(['quotation_code' => $customerInfo['quotation_code'] ])->one();
$getTermsAndConditions = TermsAndConditions::find()->all();

$this->title = 'Print Job-Sheet';

$n = 0;
$i = 1;
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
                                        <b>Name : </b> <?= Html::encode($customerInfo['name']) ?>
                                    </div>

                                    <div style="margin-top: -20px;" class="col-md-12">
                                        <b>Address : </b> <?= Html::encode($customerInfo['address']) ?>
                                    </div>

                                </div>

                            </td>
                            
                            <td style="width: 45%">
                                    <div class="row" style="text-align: left; font-size: 11px;">
                                     
                                     <div class="col-md-12"><b>JOB SHEET</b></div>
                                     <br/>

                                     <div class="col-md-6">
                                         
                                         <div class="col-md-12"><b>Date</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Jobsheet No.</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Vehicle No.</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Make</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Model</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Date & Time In</b></div>
                                         <br/>

                                         <div class="col-md-12"><b>Date & Time Out</b></div>
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
                                            : <?= Html::encode(date('d M Y', strtotime($customerInfo['date_issue']))) ?> 
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($customerInfo['quotation_code']) ?> 
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($customerInfo['carplate']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($customerInfo['make']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($customerInfo['model']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode(date('d M Y', strtotime($customerInfo['created_at']))) ?>
                                              <?= Html::encode(date('H:i:s', strtotime($customerInfo['time_created']))) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode(date('d M Y H:i:s')) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($customerInfo['office_no']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($customerInfo['hanphone_no']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($customerInfo['hanphone_no']) ?>
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : 0
                                         </div>
                                         <br/>

                                         <div class="col-md-12">
                                            : <?= Html::encode($customerInfo['points']) ?>
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
                
                <td class="servicespartsContainerHeader" style="width: 50%; text-align: center; font-size: 11px;" > Description </td>
                <td class="servicespartsContainerHeader" style="width: 20%; text-align: center; font-size: 11px;" > Qty</td>
                <td class="servicespartsContainerHeader" style="width: 20%; text-align: center; font-size: 11px;" > Line Total w/o GST</td>
                </tr></table>
            </tr>

            <tr class="details">
              
                <table border="1" style="border: solid 1px #666; " cellspacing ="0" cellpadding ="0" >
                    <tbody>
                        <?php foreach($services as $sRow): ?>
                            <?php $n++; ?>
                            <tr>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" ><?php echo $n; ?></td>
                                <td class="servicespartsLists" style="width: 50%; text-align: center; font-size: 11px;" ><?php echo $sRow['service_name']; ?></td>
                                <td class="servicespartsLists" style="width: 20%; text-align: center; font-size: 11px;" ><?php echo $sRow['quantity']; ?></td>
                                <td class="servicespartsLists" style="width: 20%; text-align: center; font-size: 11px;" ><?php echo '$ '.$sRow['subTotal'].'.00'; ?></td>
                            </tr>
                        <?php endforeach; ?>  
                        <?php foreach($parts as $pRow): ?>
                            <?php $i += $n; ?>
                            <tr>
                                <td class="servicespartsLists" style="width: 10%; text-align: center; font-size: 11px;" ><?php echo $i; ?></td>
                                <td class="servicespartsLists" style="width: 50%; text-align: center; font-size: 11px;" ><?php echo $pRow['product_name']; ?></td>
                                <td class="servicespartsLists" style="width: 20%; text-align: center; font-size: 11px;" ><?php echo $pRow['quantity']; ?></td>
                                <td class="servicespartsLists" style="width: 20%; text-align: center; font-size: 11px;" ><?php echo '$ '.$pRow['subTotal'].'.00'; ?></td>
                            </tr>

                        <?php endforeach; ?> 
                    </tbody>
                </table>
            
            </tr>

            <tr class="item">
                
                <table >
                    <tbody>
                        <tr>
                            <td><img src="assets/bootstrap/images/arh_receipt_carimages.png" style="width: 100%; height: 100%;"></img></td>
                        </tr>
                    </tbody>
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

            <tr><br/></tr>

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
<br/>

<!-- Print Buttons -->   
<div class="row">
    <div class="col-xs-12">
        <div style="text-align: center">
            <button class="form-btn btn btn-info btn-xs print-buttons" id="print_quotation" onclick="quotationPrint()"><i class="fa fa-print"></i> Print </button>
       
            <button class="form-btn btn btn-danger btn-xs print-buttons close_print" id="close_print"><i class="fa fa-close"></i> Close </button>
      
        </div>
    </div>
</div>

<br/><br/>

    
