<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Monthly Stock Report';

?>

<div class="row form-container">

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-bar-chart"></i> MONTHLY STOCK REPORT</h4></span>
    </div>
    <hr/>

    <div class="form-search-container">    
      <?php echo $this->render('_search-monthly-stock'); ?>
    </div> 
    
</div>

 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/>

    <table class="table table-striped table-boardered table-hover reportsTable">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" ><b>SUPPLIER NAME</b></th>
            <th class="tblalign_center" ><b>PRODUCT NAME</b></th>
            <th class="tblalign_center" ><b>QUANTITY</b></th>
            <th class="tblalign_center" ><b>COST PRICE</b></th>
            <th class="tblalign_center" ><b>SELLING PRICE</b></th>
            <th class="tblalign_center" ><b>DATE IMPORTED</b></th>
        </tr>
    </thead>

    <tbody>
    	<?php if( !empty($getMonthlyStock) ): ?>
            <?php foreach( $getMonthlyStock as $row){ ?>
                <tr >
                    <td class="tblalign_center" ><?php echo $row['supplier_name'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['product_name'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['quantity'];  ?></td>
                    <td  class="tblalign_center" ><?php echo $row['cost_price'];  ?></td>
                    <td  class="tblalign_center" ><?php echo $row['selling_price'];  ?></td>
                    <td  class="tblalign_center" ><?php echo date('m-d-Y', strtotime($row['date_imported']) );  ?></td>
                </tr>
            <?php } ?> 
        <?php else: ?>
            <tr>
                <td><span>No Record Found.</span></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        <?php endif; ?> 
    </tbody>
    </table>
 
</div>

<div class="btnreportsAlign" >
    <p>
        <a href="?r=reports/monthly-stock-export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="form-btn btn btn-round btn-default">
            <i class="fa fa-file-excel-o"></i> <b> Export to Excel </b>
        </a>

        <a href="?r=reports/monthly-stock-export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="form-btn btn btn-round btn-default">
            <i class="fa fa-file-pdf-o"></i> <b> Export to PDF </b>
        </a>
    </p>
</div>

<div style="color:#fff">|<br/></div>

</div>
<br/>

















