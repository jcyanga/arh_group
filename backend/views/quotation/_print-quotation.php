<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;
use common\models\Invoice;
use common\models\TermsAndConditions;

$getGst = Gst::find()->where(['branch_id' => $customerInfo['BranchId'] ])->one();

$getInvoice = Invoice::find()->where(['quotation_code' => $customerInfo['quotation_code'] ])->one();
$getTermsAndConditions = TermsAndConditions::find()->where(['status' => 1])->all();

$this->title = 'Print Job-Sheet';

$n = 0;
$x = 0;

?>
    
<div class="invoice-box page">
<table cellpadding="0" cellspacing="0">

<tr class="top">
<td colspan="2">
    <table>
        <tr>
            <td class="title">
                <div style="text-align: left">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="images/dashboard/logo.png" class="jiReceiptLogo">
                        </div>
                        <div style="width: 60%;"  class="col-md-8">
                            <div class="row branchcustomerContainer" >
                                <div class="col-md-12 branchName">
                                    <b> <?= Html::encode($customerInfo['name']) ?> </b> 
                                </div>
                                <div class="col-md-12 addressInfo">
                                    <?= Html::encode($customerInfo['address']) ?>
                                </div>
                            </div>
                            <div class="row customerInfoContainer" >
                                <?php if($customerInfo['type'] == 1): ?>
                                    <div class="col-md-12 customerName">
                                        <b>Name : </b> <?= Html::encode($customerInfo['company_name']) ?>
                                    </div>
                                    <div class="col-md-12 customerAddressInfo">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12 customerName">
                                        <b>Name : </b> <?= Html::encode($customerInfo['fullname']) ?>
                                    </div>
                                    <div class="col-md-12 customerAddressInfo">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </div>
                                <?php endif; ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            
            <td style="width: 50%">
                    <div class="row jobsheetinvoiceLabel" >
                     
                     <div class="col-md-12 jobsheetinvoiceHeaderAlign"><b>JOB SHEET</b></div>
                     <br/>

                     <div class="col-md-6">
                         
                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceDate"><b>Date :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceNo"><b>Jobsheet No. :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceVehicle"><b>Vehicle No. :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceMake"><b>Make :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceModel"><b>Model :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceComeIn"><b>Date & Time In :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceComeOut"><b>Date & Time Out :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceCompanyTel"><b>Company Tel. :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceHomeTel"><b>Home Tel. :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceHanphoneTel"><b>Mobile :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceMileage"><b>Mileage :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoicePoints"><b>Balance Points :</b></div>

                     </div>
                     
                     <div class="col-md-6">
                         
                         <div class="col-md-12 jobsheetinvoiceDate">
                            &nbsp; <?= Html::encode(date('d M Y', strtotime($customerInfo['date_issue']))) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceNo">
                            &nbsp; <?= Html::encode($customerInfo['quotation_code']) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceVehicle">
                            &nbsp; <?= Html::encode($customerInfo['carplate']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceMake">
                            &nbsp; <?= Html::encode($customerInfo['make']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceModel">
                            &nbsp; <?= Html::encode($customerInfo['model']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceComeIn">
                            &nbsp; <?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_in']))) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceComeOut">
                            &nbsp; <?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_out']))) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceCompanyTel">
                            &nbsp; <?= Html::encode($customerInfo['office_no']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceHomeTel">
                            &nbsp; <?= Html::encode($customerInfo['hanphone_no']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceHanphoneTel">
                            &nbsp; <?= Html::encode($customerInfo['hanphone_no']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceMileage">
                            &nbsp; <?= Html::encode($customerInfo['mileage']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoicePoints">
                            &nbsp; <?= Html::encode($customerInfo['points']) ?>
                         </div>

                     </div>
   
                    </div>
            </td>
        </tr>
    </table>
</td>
</tr>

    <tr class="heading">
    <table>
        <tr>
            <td><input type="checkbox" class="showPrices" id="showPrices" /><span class="hidePriceLabel" id="hidePriceLabel"> Hide Prices ?</span></td>
        </tr>
    </table>
        <table class="headers quoOrderHeader">
            <tr>
                <td class="servicespartsContainerHeader" id="receiptorderNumberHeader" > S/No </td>                   
                <td class="servicespartsContainerHeader" id="receiptorderDescriptionHeader" > Description </td>
                <td class="servicespartsContainerHeader" id="receiptorderQtyHeader" > Qty</td>
                <td class="servicespartsContainerHeader quoSubtotalHeader" id="receiptorderSubtotalHeader" > Line Total w/o GST</td>
            </tr>
        </table>
    </tr>

    <tr class="details">
        <table border="1" class="receiptorderTable quoOrderContent" cellspacing ="0" cellpadding ="0" >
            <tbody>
                <?php foreach($services as $key => $sRow): ?>
                    <?php $n++; ?>
                    <tr>
                        <td class="servicespartsLists" id="orderNumbers" ><?php echo $n; ?></td>
                        <td class="servicespartsLists" id="orderDescriptions" ><?php echo $sRow['service_part_id']; ?></td>
                        <td class="servicespartsLists" id="orderQtys" ><?php echo $sRow['quantity']; ?></td>
                        <td class="servicespartsLists quoServiceSubtotal" id="orderSubtotals" >$ <?php echo number_format($sRow['subTotal'],2); ?></td>
                    </tr>
                    <?php unset($services[$key]); ?>
            <?php if($n == 8){ break; } ?>
                <?php endforeach; ?>  
                <?php foreach($parts as $key => $pRow): ?>
                    <?php $n++; ?>
                    <tr>
                        <td class="servicespartsLists" id="orderNumbers" ><?php echo $n; ?></td>
                        <td class="servicespartsLists" id="orderDescriptions" ><?php echo $pRow['product_name']; ?></td>
                        <td class="servicespartsLists" id="orderQtys" ><?php echo $pRow['quantity']; ?></td>
                        <td class="servicespartsLists quoPartsSubtotal" id="orderSubtotals" >$ <?php echo number_format($pRow['subTotal'],2); ?></td>
                    </tr>
                    <?php unset($parts[$key]); ?>
                    <?php if($n == 8){ break; } ?>
                <?php endforeach; ?> 
            </tbody>
        </table>
    </tr>

    <?php if( $n < 8 ): ?>
    <tr class="item">
        <table >
            <tbody>
                <tr>
                    <td><img src="assets/bootstrap/images/arh_receipt_carimages.png" class="carSize"></img></td>
                </tr>
            </tbody>
        </table>
    </tr>

    <tr class="item">
        <small style="font-size: 12px;"><b>Terms and Conditions</b></small>
        <br/>
        <?php foreach($getTermsAndConditions as $tcRow): ?>
            <?php $x++; ?>
            <p class="termsandconditionsLists" ><?php echo $x . '.)'; ?> <?php echo $tcRow['descriptions']; ?><br/></p>
        <?php endforeach; ?>  
    </tr>

    <tr><br/><br/></tr>

    <tr class="item">
        <table >
            <tbody>
                <tr>
                    <td class="attendedSideContainer" >
                        <hr class="hrLine" />
                        <h5 class="receiptbottomInfo" >Attended by</h5>
                    </td>

                    <td class="dateSideContainer" >
                        <hr class="hrLine" />
                        <h5 class="receiptbottomInfo" >Date</h5>
                    </td>

                    <td class="customerSideContainer">
                        <hr class="hrLine" />
                        <h5 class="receiptbottomInfo" >Name, NRIC & Signature or Authorised Signature & Company Shop</h5>
                    </td>
                </tr>
            </tbody>
        </table>
    </tr>

    <?php endif; ?>

    </table>

</div>

<?php if( $n >= 8 ): ?>

<div class="invoice-box page">
<table cellpadding="0" cellspacing="0">

<tr class="top">
<td colspan="2">
    <table>
        <tr>
            <td class="title">
                <div style="text-align: left">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="images/dashboard/logo.png" class="jiReceiptLogo">
                        </div>
                        <div style="width: 60%;"  class="col-md-8">
                            <div class="row branchcustomerContainer" >
                                <div class="col-md-12 branchName">
                                    <b> <?= Html::encode($customerInfo['name']) ?> </b> 
                                </div>
                                <div class="col-md-12 addressInfo">
                                    <?= Html::encode($customerInfo['address']) ?>
                                </div>
                            </div>
                            <div class="row customerInfoContainer" >
                                <?php if($customerInfo['type'] == 1): ?>
                                    <div class="col-md-12 customerName">
                                        <b>Name : </b> <?= Html::encode($customerInfo['company_name']) ?>
                                    </div>
                                    <div class="col-md-12 customerAddressInfo">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12 customerName">
                                        <b>Name : </b> <?= Html::encode($customerInfo['fullname']) ?>
                                    </div>
                                    <div class="col-md-12 customerAddressInfo">
                                        <b>Address : </b> <?= Html::encode($customerInfo['customerAddress']) ?>
                                    </div>
                                <?php endif; ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            
            <td style="width: 50%">
                    <div class="row jobsheetinvoiceLabel" >
                     
                     <div class="col-md-12 jobsheetinvoiceHeaderAlign"><b>JOB SHEET</b></div>
                     <br/>

                     <div class="col-md-6">
                         
                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceDate"><b>Date</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceNo"><b>Jobsheet No.</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceVehicle"><b>Vehicle No.</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceMake"><b>Make</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceModel"><b>Model</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceComeIn"><b>Date & Time In</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceComeOut"><b>Date & Time Out</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceCompanyTel"><b>Company Tel.</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceHomeTel"><b>Home Tel.</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceHanphoneTel"><b>Mobile</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceMileage"><b>Mileage</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoicePoints"><b>Balance Points</b></div>

                     </div>
                     
                     <div class="col-md-6">
                         
                         <div class="col-md-12 jobsheetinvoiceDate">
                            : &nbsp; <?= Html::encode(date('d M Y', strtotime($customerInfo['date_issue']))) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceNo">
                            : &nbsp; <?= Html::encode($customerInfo['quotation_code']) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceVehicle">
                            : &nbsp; <?= Html::encode($customerInfo['carplate']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceMake">
                            : &nbsp; <?= Html::encode($customerInfo['make']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceModel">
                            : &nbsp; <?= Html::encode($customerInfo['model']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceComeIn">
                            : &nbsp; <?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_in']))) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceComeOut">
                            : &nbsp; <?= Html::encode(date('d M Y H:i:s', strtotime($customerInfo['come_out']))) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceCompanyTel">
                            : &nbsp; <?= Html::encode($customerInfo['office_no']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceHomeTel">
                            : &nbsp; <?= Html::encode($customerInfo['hanphone_no']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceHanphoneTel">
                            : &nbsp; <?= Html::encode($customerInfo['hanphone_no']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceMileage">
                            : &nbsp; <?= Html::encode($customerInfo['mileage']) ?>
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoicePoints">
                            : &nbsp; <?= Html::encode($customerInfo['points']) ?>
                         </div>

                     </div>
   
                    </div>
            </td>
        </tr>
    </table>
</td>
</tr>

    <tr class="heading">
        <table class="headers">
            <tr>
                <td class="servicespartsContainerHeader" id="receiptorderNumberHeader" > S/No </td>                   
                <td class="servicespartsContainerHeader" id="receiptorderDescriptionHeader" > Description </td>
                <td class="servicespartsContainerHeader" id="receiptorderQtyHeader" > Qty</td>
                <td class="servicespartsContainerHeader" id="receiptorderSubtotalHeader" > Line Total w/o GST</td>
            </tr>
        </table>
    </tr>

    <tr class="details">
        <table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
            <tbody>
                <?php foreach($services as $key => $sRow): ?>
                    <?php $n++; ?>
                    <tr>
                        <td class="servicespartsLists" id="orderNumbers" ><?php echo $n; ?></td>
                        <td class="servicespartsLists" id="orderDescriptions" ><?php echo $sRow['service_part_id']; ?></td>
                        <td class="servicespartsLists" id="orderQtys" ><?php echo $sRow['quantity']; ?></td>
                        <td class="servicespartsLists" id="orderSubtotals" >$ <?php echo number_format($sRow['subTotal'],2); ?></td>
                    </tr>
                    <?php unset($services[$key]); ?>
            <?php if($n == 8){ break; } ?>
                <?php endforeach; ?>  
                <?php foreach($parts as $key => $pRow): ?>
                    <?php $n++; ?>
                    <tr>
                        <td class="servicespartsLists" id="orderNumbers" ><?php echo $n; ?></td>
                        <td class="servicespartsLists" id="orderDescriptions" ><?php echo $pRow['product_name']; ?></td>
                        <td class="servicespartsLists" id="orderQtys" ><?php echo $pRow['quantity']; ?></td>
                        <td class="servicespartsLists" id="orderSubtotals" >$ <?php echo number_format($pRow['subTotal'],2); ?></td>
                    </tr>
                    <?php unset($parts[$key]); ?>
                    <?php if($n == 8){ break; } ?>
                <?php endforeach; ?> 
            </tbody>
        </table>
    </tr>

    <tr class="item">
        <table >
            <tbody>
                <tr>
                    <td><img src="assets/bootstrap/images/arh_receipt_carimages.png" class="carSize"></img></td>
                </tr>
            </tbody>
        </table>
    </tr>

    <tr class="item">
        <small style="font-size: 12px;"><b>Terms and Conditions</b></small>
        <br/>
        <?php foreach($getTermsAndConditions as $tcRow): ?>
            <?php $x++; ?>
            <p class="termsandconditionsLists" ><?php echo $x . '.)'; ?> <?php echo $tcRow['descriptions']; ?><br/></p>
        <?php endforeach; ?>  
    </tr>

    <tr><br/><br/></tr>

    <tr class="item">
        <table >
            <tbody>
                <tr>
                    <td class="attendedSideContainer" >
                        <hr class="hrLine" />
                        <h5 class="receiptbottomInfo" >Attended by</h5>
                    </td>

                    <td class="dateSideContainer" >
                        <hr class="hrLine" />
                        <h5 class="receiptbottomInfo" >Date</h5>
                    </td>

                    <td class="customerSideContainer">
                        <hr class="hrLine" />
                        <h5 class="receiptbottomInfo" >Name, NRIC & Signature or Authorised Signature & Company Shop</h5>
                    </td>
                </tr>
            </tbody>
        </table>
    </tr>

    </table>

</div>

<?php endif; ?>

<!-- Print Buttons -->   
<div class="row">
    <div class="col-xs-12">
        <div style="text-align: center">
            <button class="form-btn btn btn-info btn-xs print-buttons" id="print_quotation" onclick="quotationPrint()"><i class="fa fa-print"></i> Print </button>
       
            <button class="form-btn btn btn-danger btn-xs print-buttons" id="closeQuotePrint"><i class="fa fa-close"></i> Close </button>
      
        </div>
    </div>
</div>

<br/>
