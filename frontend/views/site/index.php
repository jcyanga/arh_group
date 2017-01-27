<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';

?>

<div style="margin-top: 50px;">

<!-- Quotation List -->
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-desktop"></i> Quotation List 
                        <small class="searchCustomerLabel">(Non-Invoice with Pending Services)</small>
                    </h4>
                </div>
            </div>

            <?php if( !empty($getPendQuotationServices) ): ?>
                
                <table class="table table-boardered table-striped pendingTable">
                    <thead>
                        <tr class="headings">
                            <td class="tblalign_center" ><b> DATE ISSUE </b></td>
                            <td class="tblalign_center" ><b> QUOTATION CODE </b></td>
                            <td class="tblalign_center" ><b> SERVICE NAME </b></td>
                            <td class="tblalign_center" ><b> QUANTITY </b></td>
                            <td class="tblalign_center" ><b> SELLING PRICE </b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $getPendQuotationServices as $qRow): ?>
                            <tr>
                                <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($qRow['date_issue']) ); ?></td>
                                <td class="tblalign_center" ><b><?php echo $qRow['quotation_code']; ?></b></td>
                                <td class="tblalign_center" ><b><?php echo $qRow['service_name']; ?></b></td>
                                <td class="tblalign_center" ><?php echo $qRow['quantity']; ?></td>
                                <td class="tblalign_center" ><?php echo '$'.$qRow['selling_price'].'.00'; ?></td>
                            </tr>
                        <?php endforeach; ?>     
                    </tbody>
                </table>
            
            <?php else: ?>
                <div>
                    <span class="pendingNoRecordDashboard"> - No Record Found. <span>
                </div>
                <br/>
            <?php endif; ?>

        </div>

    </div>

</div>
<br/>

<!-- Quotation List -->
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-files-o"></i> Invoice List 
                        <small class="searchCustomerLabel">(Pending Services with Invoice)</small>
                    </h4>
                </div>
            </div>

            <?php if( !empty($getPendInvoiceServices) ): ?>
                
                <table class="table table-boardered table-striped pendingTable">
                    <thead>
                        <tr class="headings">
                            <td class="tblalign_center" ><b> DATE ISSUE </b></td>
                            <td class="tblalign_center" ><b> INVOICE NUMBER </b></td>
                            <td class="tblalign_center" ><b> SERVICE NAME </b></td>
                            <td class="tblalign_center" ><b> QUANTITY </b></td>
                            <td class="tblalign_center" ><b> SELLING PRICE </b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $getPendInvoiceServices as $iRow): ?>
                            <tr>
                                <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($iRow['date_issue']) ); ?></td>
                                <td class="tblalign_center" ><b><?php echo $iRow['invoice_no']; ?></b></td>
                                <td class="tblalign_center" ><b><?php echo $iRow['service_name']; ?></b></td>
                                <td class="tblalign_center" ><?php echo $iRow['quantity']; ?></td>
                                <td class="tblalign_center" ><?php echo '$'.$iRow['selling_price'].'.00'; ?></td>
                            </tr>
                        <?php endforeach; ?>     
                    </tbody>
                </table>
            
            <?php else: ?>
                <div>
                    <span class="pendingNoRecordDashboard"> - No Record Found. <span>
                </div>
                <br/>
            <?php endif; ?>

        </div>

    </div>

</div>
<br/>

