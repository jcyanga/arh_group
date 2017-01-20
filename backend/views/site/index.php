<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';

$roleId = Yii::$app->user->identity->role_id;

?>


<div style="margin-top: 50px;">

<?php if( $roleId == 1 || $roleId == 2 ): ?>
<!-- Search Customer -->
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-clipboard"></i> Customer List 
                        <small class="searchCustomerLabel">(<b>Search by:</b> Customer Name / Carplate/ Parts Name)</small>
                    </h4>
                </div>
            </div>

            <div class="x_content">
                
                <?php $form = ActiveForm::begin(['action' => '?', 'method' => 'post']); ?>
                    <div style="width: 50%;" class="input-group">
                        <input type="text" name="customerSearchkeyword" id="customerSearchBox" class="form-control" value="<?= $keywordValue ?>" placeholder="Enter keyword here." />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i> Search!</button> 
                        </span>
                    </div>
                <?php ActiveForm::end(); ?>

                <?php if( !empty($getCustomerQuotationBySearch) || !empty($getCustomerInvoiceBySearch) ): ?>
                    
                    <table class="table table-boardered table-striped pendingTable">
                        <thead>
                            <tr class="headings">
                                <td class="tblalign_center" ><b> DATE ISSUE </b></td>
                                <td class="tblalign_center" ><b> SALES PERSON </b></td>
                                <td class="tblalign_center" ><b> CUSTOMER NAME </b></td>
                                <td class="tblalign_center" ><b> CAR-PLATE </b></td>
                                <td class="tblalign_center" ><b> QUOTATION CODE / INVOICE NUMBER </b></td>
                                <td class="tblalign_center" ><b> PRODUCT NAME </b></td>
                                <td class="tblalign_center" ><b> QUOTATION PRICE </b></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $getCustomerQuotationBySearch as $custqRow): ?>
                                <tr>
                                    <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($custqRow['date_issue']) ); ?></td>
                                    <td class="tblalign_center" ><?php echo $custqRow['salesPerson']; ?></td>
                                    <td class="tblalign_center" ><b><?php echo $custqRow['customerName']; ?></b></td>
                                    <td class="tblalign_center" ><b><?php echo $custqRow['carplate']; ?></b></td>
                                    <td class="tblalign_center" ><?php echo $custqRow['quotationCode']; ?></td>
                                    <td class="tblalign_center" ><b><?php echo $custqRow['product_name']; ?></b></td>
                                    <td class="tblalign_center" ><b><?php echo '$'.$custqRow['quotationPartsPrice'].'.00'; ?></b></td>
                                </tr>
                            <?php endforeach; ?>    

                            <?php foreach( $getCustomerInvoiceBySearch as $custiRow): ?>
                                <tr>
                                    <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($custiRow['date_issue']) ); ?></td>
                                    <td class="tblalign_center" ><?php echo $custiRow['salesPerson']; ?></td>
                                    <td class="tblalign_center" ><b><?php echo $custiRow['customerName']; ?></b></td>
                                    <td class="tblalign_center" ><b><?php echo $custiRow['carplate']; ?></b></td>
                                    <td class="tblalign_center" ><?php echo $custiRow['invoiceNo']; ?></td>
                                    <td class="tblalign_center" ><b><?php echo $custiRow['product_name']; ?></b></td>
                                    <td class="tblalign_center" ><b><?php echo '$'.$custiRow['invoicePartsPrice'].'.00'; ?></b></td>
                                </tr>
                            <?php endforeach; ?>    
                        </tbody>
                    </table>
                
                <?php else: ?>
                    <div>
                        <span class="pendingNoRecordDashboard"> - No Search Found. <span>
                    </div>
                    <br/>
                <?php endif; ?>

            </div>

        </div>

    </div>

</div>
<br/>
<?php endif; ?>

<?php if( $roleId == 1 || $roleId == 2 ): ?>
<!-- Pending Quotation -->
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-map-marker"></i> Pending Quotation Services 
                        <small class="searchCustomerLabel">(Non-Invoice with Pending Services)</small>
                    </h4>
                </div>
            </div>

            <?php if( !empty($pendingQuotationServices) ): ?>
                
                <table class="table table-boardered table-striped pendingTable">
                    <thead>
                        <tr class="headings">
                            <td class="tblalign_center" ><b> DATE ISSUE </b></td>
                            <td class="tblalign_center" ><b> QUOTATION CODE </b></td>
                            <td class="tblalign_center" ><b> CUSTOMER NAME </b></td>
                            <td class="tblalign_center" ><b> SERVICE NAME </b></td>
                            <td class="tblalign_center" ><b> QUANTITY </b></td>
                            <td class="tblalign_center" ><b> SELLING PRICE </b></td>
                            <td class="tblalign_center" ><b> CHECK QUOTATION </b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $pendingQuotationServices as $qRow): ?>
                            <tr>
                                <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($qRow['date_issue']) ); ?></td>
                                <td class="tblalign_center" ><b><?php echo $qRow['quotation_code']; ?></b></td>
                                <td class="tblalign_center" ><?php echo $qRow['fullname']; ?></td>
                                <td class="tblalign_center" ><b><?php echo $qRow['service_name']; ?></b></td>
                                <td class="tblalign_center" ><?php echo $qRow['quantity']; ?></td>
                                <td class="tblalign_center" ><?php echo '$'.$qRow['selling_price'].'.00'; ?></td>
                                <td class="tblalign_center" ><a href="?r=quotation/view&id=<?php echo $qRow['quotationId']; ?>" > <i class="fa fa-search"></i> </a></td>
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

<!-- Pending Invoice -->
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        
        <div class="dashboard_graph x_panel">
            
            <div class="row x_title">
                <div class="col-md-6">
                    <h4>
                        <i class="fa fa-map-marker"></i> Pending Invoice Services 
                        <small class="searchCustomerLabel">(Pending Services with Invoice)</small>
                    </h4>
                </div>
            </div>

            <?php if( !empty($pendingInvoiceServices) ): ?>
                
                <table class="table table-boardered table-striped pendingTable">
                    <thead>
                        <tr class="headings">
                            <td class="tblalign_center" ><b> DATE ISSUE </b></td>
                            <td class="tblalign_center" ><b> INVOICE NUMBER </b></td>
                            <td class="tblalign_center" ><b> CUSTOMER NAME </b></td>
                            <td class="tblalign_center" ><b> SERVICE NAME </b></td>
                            <td class="tblalign_center" ><b> QUANTITY </b></td>
                            <td class="tblalign_center" ><b> SELLING PRICE </b></td>
                            <td class="tblalign_center" ><b> CHECK INVOICE </b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $pendingInvoiceServices as $iRow): ?>
                            <tr>
                                <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($iRow['date_issue']) ); ?></td>
                                <td class="tblalign_center" ><b><?php echo $iRow['invoice_no']; ?></b></td>
                                <td class="tblalign_center" ><?php echo $iRow['fullname']; ?></td>
                                <td class="tblalign_center" ><b><?php echo $iRow['service_name']; ?></b></td>
                                <td class="tblalign_center" ><?php echo $iRow['quantity']; ?></td>
                                <td class="tblalign_center" ><?php echo '$'.$iRow['selling_price'].'.00'; ?></td>
                                <td class="tblalign_center" ><a href="?r=invoice/view&id=<?php echo $iRow['invoiceId']; ?>" > <i class="fa fa-search"></i> </a></td>
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
<?php endif; ?>

<?php if( $roleId == 1 || $roleId == 2 || $roleId == 3 ): ?>
<div class="row">

    <!-- Warning Stock -->
    <div class="col-md-4 col-sm-4 col-xs-12">

        <div class="x_panel">

            <div class="x_title">
                <h5><b> <i class="fa fa-sort-amount-desc"></i> Parts in Warning Stock <i class="fa fa-cubes"></i> </b></h5>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="dashboard-widget-content">

                    <ul class="list-unstyled timeline widget">
                       <?php if( !empty($getWarningStock) ): ?>
                           <?php foreach( $getWarningStock as $wStock ): ?>        
                                <li>
                                    <div class="block">
                                        <div class="block_content">
                                            <h2 class="title">
                                                <a class="partsDashboard"> 
                                                    <i class="fa fa-dropbox"></i><?php echo $wStock['product_name']; ?> [<?php echo $wStock['quantity']; ?>] 
                                                </a>
                                            </h2>
                                        </div>
                                    </div>
                                </li>   
                            <?php endforeach; ?>
                                <div class="partsTotalDashboard">
                                    <a href="?r=stocks">
                                        See All (<?= $getTotalWarningStock ?>) 
                                    </a>
                                </div>
                        <?php else: ?>
                            <li>
                                <div class="block">
                                    <div class="block_content">
                                        <h2 class="title">
                                            <a class="partsNoRecordDashboard">
                                                - No Record Found.
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </li>  
                        <?php endif; ?>
                    </ul>

                </div>
            </div>

        </div>

    </div>

    <!-- Critical Stock -->
    <div class="col-md-4 col-sm-4 col-xs-12">

        <div class="x_panel">

            <div class="x_title">
                <h5><b> <i class="fa fa-sort-amount-desc"></i> Parts in Critical Stock <i class="fa fa-cubes"></i> </b></h5>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="dashboard-widget-content">

                    <ul class="list-unstyled timeline widget">
                       <?php if( !empty($getCriticalStock) ): ?>
                           <?php foreach( $getCriticalStock as $cStock ): ?>        
                                <li>
                                    <div class="block">
                                        <div class="block_content">
                                            <h2 class="title">
                                                <a class="partsDashboard"> 
                                                    <i class="fa fa-dropbox"></i><?php echo $cStock['product_name']; ?> [<?php echo $cStock['quantity']; ?>] 
                                                </a>
                                            </h2>
                                        </div>
                                    </div>
                                </li>   
                            <?php endforeach; ?>
                                <div class="partsTotalDashboard">
                                    <a href="?r=stocks">
                                        See All (<?= $getTotalCriticalStock ?>) 
                                    </a>
                                </div>
                        <?php else: ?>
                            <li>
                                <div class="block">
                                    <div class="block_content">
                                        <h2 class="title">
                                            <a class="partsNoRecordDashboard">
                                                - No Record Found.
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </li>  
                        <?php endif; ?>
                    </ul>

                </div>
            </div>

        </div>

    </div>

    <!--  Zero Stock -->
    <div class="col-md-4 col-sm-4 col-xs-12">

        <div class="x_panel">

            <div class="x_title">
                <h5><b> <i class="fa fa-sort-amount-desc"></i> Parts in Zero Stock <i class="fa fa-cubes"></i> </b></h5>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="dashboard-widget-content">

                    <ul class="list-unstyled timeline widget">
                       <?php if( !empty($getZeroStock) ): ?>
                           <?php foreach( $getZeroStock as $zStock ): ?>        
                                <li>
                                    <div class="block">
                                        <div class="block_content">
                                            <h2 class="title">
                                                <a class="partsDashboard"> 
                                                    <i class="fa fa-dropbox"></i><?php echo $zStock['product_name']; ?> [<?php echo $zStock['quantity']; ?>] 
                                                </a>
                                            </h2>
                                        </div>
                                    </div>
                                </li>   
                            <?php endforeach; ?>
                                <div class="partsTotalDashboard">
                                    <a href="?r=stocks">
                                        See All (<?= $getTotalZeroStock ?>) 
                                    </a>
                                </div>
                        <?php else: ?>
                            <li>
                                <div class="block">
                                    <div class="block_content">
                                        <h2 class="title">
                                            <a class="partsNoRecordDashboard">
                                                - No Record Found.
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </li>  
                        <?php endif; ?>
                    </ul>

                </div>
            </div>

        </div>

    </div>
    <br/>

</div>
<?php endif; ?>

</div>

