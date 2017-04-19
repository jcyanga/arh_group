<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

use common\models\Gst;
use common\models\TermsAndConditions;

$getTermsAndConditions = TermsAndConditions::find()->where(['status' => 1])->all();
$id = Yii::$app->request->get('id');

$this->title = 'Print Invoice';

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
                     
                     <div class="col-md-12 jobsheetinvoiceHeaderAlign1"><b>INVOICE / CASH BILL</b></div>
                     <br/>

                     <div class="col-md-6">
                         
                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceNo"><b>Invoice No. :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceTerms"><b>Terms :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceComeIn"><b>Date & Time In :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceComeOut"><b>Date & Time Out :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceVehicle"><b>Vehicle No. :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceMake"><b>Make :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceModel"><b>Model :</b></div>
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
                         
                         <div class="col-md-12 jobsheetinvoiceNo">
                            &nbsp; <?= Html::encode($customerInfo['invoice_no']) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceTerms">
                            &nbsp; <?= Html::encode($customerInfo['paymenttypeName']) ?>
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
        <table class="headers">
            <tr>
                <td class="servicespartsContainerHeader" id="invoiceorderNumberHeader" > S/No </td>   
                <td class="servicespartsContainerHeader" id="invoiceorderDescriptionHeader" > Description </td>
                <td class="servicespartsContainerHeader" id="invoiceorderUnitPriceHeader" > Unit Price</td>
                <td class="servicespartsContainerHeader" id="invoiceorderQtyHeader" > Qty</td>
                <td class="servicespartsContainerHeader" id="invoiceorderDiscountHeader" > Member Discount</td>
                <td class="servicespartsContainerHeader" id="invoiceorderAddDiscountHeader" > Additional Discount</td>
                <td class="servicespartsContainerHeader" id="invoiceorderSubTotalHeader" > Line Total w/o GST</td>
            </tr>
        </table>
    </tr>

    <tr class="details">
        <table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
            <tbody>
                <?php foreach($services as $key => $sRow): ?>
                    <?php $n++; ?>
                    <tr>
                        <td class="servicespartsLists" id="invoiceorderNumber" ><?php echo $n; ?></td>
                        <td class="servicespartsLists" id="invoiceorderDescription" ><?php echo $sRow['service_part_id']; ?></td>
                        <td class="servicespartsLists" id="invoiceorderUnitPrice" >$ <?php echo number_format($sRow['selling_price'],2); ?></td>
                        <td class="servicespartsLists" id="invoiceorderQty" ><?php echo $sRow['quantity']; ?></td>
                        <td class="servicespartsLists" id="invoiceorderDiscount" >-</td>
                        <td class="servicespartsLists" id="invoiceorderAddDiscount" >-</td>
                        <td class="servicespartsLists" id="invoiceorderSubTotal" >$ <?php echo number_format($sRow['subTotal'],2); ?></td>
                    </tr>
                    <?php unset($services[$key]); ?>
                    <?php if($n == 8){ break; } ?>
                <?php endforeach; ?>  
                <?php foreach($parts as $pkey => $pRow): ?>
                    <?php $n++; ?>
                    <tr>
                        <td class="servicespartsLists" id="invoiceorderNumber" ><?php echo $n; ?></td>
                        <td class="servicespartsLists" id="invoiceorderDescription" ><?php echo $pRow['product_name']; ?></td>
                        <td class="servicespartsLists" id="invoiceorderUnitPrice" >$ <?php echo number_format($pRow['selling_price'],2); ?></td>
                        <td class="servicespartsLists" id="invoiceorderQty" ><?php echo $pRow['quantity']; ?></td>
                        <td class="servicespartsLists" id="invoiceorderDiscount" >-</td>
                        <td class="servicespartsLists" id="invoiceorderAddDiscount" >-</td>
                        <td class="servicespartsLists" id="invoiceorderSubTotal" >$ <?php echo number_format($pRow['subTotal'],2); ?></td>
                    </tr>
                    <?php unset($parts[$pkey]); ?>
                    <?php if($n == 8){ break; } ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if( $n < 8 ): ?>
        <table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Sub-Total</b></td>
                <td class="servicespartsLists" id="invoicesubTableInfo" ><b>$ <?php echo number_format($customerInfo['grand_total'],2) ?></b></td>
            </tr>
            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Discount</b></td>
                <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo number_format($customerInfo['discount_amount'],2); ?></b></td>
            </tr>
            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Redeem Points</b></td>
                <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo $customerInfo['points_redeem']; ?></b></td>
            </tr>
            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>GST(7.00%)</b></td>
                <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo number_format($customerInfo['gst'],2); ?></b></td>
            </tr>
            <tr>
                <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Nett Total</b></td>
                <td class="servicespartsLists" id="invoicesubTableInfo" ><b>$ <?php echo number_format($customerInfo['net'],2); ?></b></td>
            </tr>
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

                    
                    </td>
                </tr>
            </tbody>
        </table>
   
    </tr>

</table>
<?php endif; ?>

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
                     
                     <div class="col-md-12 jobsheetinvoiceHeaderAlign1"><b>INVOICE / CASH BILL</b></div>
                     <br/>

                     <div class="col-md-6">
                         
                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceNo"><b>Invoice No. :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceTerms"><b>Terms :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceComeIn"><b>Date & Time In :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceComeOut"><b>Date & Time Out :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceVehicle"><b>Vehicle No. :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceMake"><b>Make :</b></div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceAlign jobsheetinvoiceModel"><b>Model :</b></div>
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
                         
                         <div class="col-md-12 jobsheetinvoiceNo">
                            &nbsp; <?= Html::encode($customerInfo['invoice_no']) ?> 
                         </div>
                         <br/>

                         <div class="col-md-12 jobsheetinvoiceTerms">
                            &nbsp; <?= Html::encode($customerInfo['paymenttypeName']) ?>
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
    <table class="headers">
        <tr>
            <td class="servicespartsContainerHeader" id="invoiceorderNumberHeader" > S/No </td>   
            <td class="servicespartsContainerHeader" id="invoiceorderDescriptionHeader" > Description </td>
            <td class="servicespartsContainerHeader" id="invoiceorderUnitPriceHeader" > Unit Price</td>
            <td class="servicespartsContainerHeader" id="invoiceorderQtyHeader" > Qty</td>
            <td class="servicespartsContainerHeader" id="invoiceorderDiscountHeader" > Member Discount</td>
            <td class="servicespartsContainerHeader" id="invoiceorderAddDiscountHeader" > Additional Discount</td>
            <td class="servicespartsContainerHeader" id="invoiceorderSubTotalHeader" > Line Total w/o GST</td>
        </tr>
    </table>
</tr>

<tr class="details">
<table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
    <tbody>
        <?php foreach($services as $key => $sRow): ?>
            <?php $n++; ?>
            <tr>
                <td class="servicespartsLists" id="invoiceorderNumber" ><?php echo $n; ?></td>
                <td class="servicespartsLists" id="invoiceorderDescription" ><?php echo $sRow['service_part_id']; ?></td>
                <td class="servicespartsLists" id="invoiceorderUnitPrice" >$ <?php echo number_format($sRow['selling_price'],2); ?></td>
                <td class="servicespartsLists" id="invoiceorderQty" ><?php echo $sRow['quantity']; ?></td>
                <td class="servicespartsLists" id="invoiceorderDiscount" >-</td>
                <td class="servicespartsLists" id="invoiceorderAddDiscount" >-</td>
                <td class="servicespartsLists" id="invoiceorderSubTotal" >$ <?php echo number_format($sRow['subTotal'],2); ?></td>
            </tr>
        <?php endforeach; ?>  
        <?php foreach($parts as $pRow): ?>
            <?php $n++; ?>
            <tr>
                <td class="servicespartsLists" id="invoiceorderNumber" ><?php echo $n; ?></td>
                <td class="servicespartsLists" id="invoiceorderDescription" ><?php echo $pRow['product_name']; ?></td>
                <td class="servicespartsLists" id="invoiceorderUnitPrice" >$ <?php echo number_format($pRow['selling_price'],2); ?></td>
                <td class="servicespartsLists" id="invoiceorderQty" ><?php echo $pRow['quantity']; ?></td>
                <td class="servicespartsLists" id="invoiceorderDiscount" >-</td>
                <td class="servicespartsLists" id="invoiceorderAddDiscount" >-</td>
                <td class="servicespartsLists" id="invoiceorderSubTotal" >$ <?php echo number_format($pRow['subTotal'],2); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<table border="1" class="receiptorderTable" cellspacing ="0" cellpadding ="0" >
    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Sub-Total</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b>$ <?php echo number_format($customerInfo['grand_total'],2) ?></b></td>
    </tr>
    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Discount</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo number_format($customerInfo['discount_amount'],2); ?></b></td>
    </tr>
    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Redeem Points</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo $customerInfo['points_redeem']; ?></b></td>
    </tr>
    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>GST(7.00%)</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b> <?php echo number_format($customerInfo['gst'],2); ?></b></td>
    </tr>
    <tr>
        <td class="servicespartsLists" id="invoicesubTableLabel" ><b>Nett Total</b></td>
        <td class="servicespartsLists" id="invoicesubTableInfo" ><b>$ <?php echo number_format($customerInfo['net_with_interest'],2); ?></b></td>
    </tr>
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
            <button class="form-btn btn btn-info btn-xs print-buttons" id="print_invoice" onclick="invoicePrint()"><i class="fa fa-print"></i> Print </button>
       
            <button class="form-btn btn btn-danger btn-xs print-buttons close_invoice_print" id="close_invoice_print"><i class="fa fa-close"></i> Close </button>
      
        </div>
    </div>
</div>

<br/>
