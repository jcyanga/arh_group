<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

if( !empty(Yii::$app->request->get('date_start')) || !empty(Yii::$app->request->get('date_end')) ) {
    $date_start = Yii::$app->request->get('date_start');
    $date_end = Yii::$app->request->get('date_end');

}else{
    $date_start = '';
    $date_end = '';

}

$this->title = 'Monthly Sales Report';

?>

<div class="row form-container">

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-bar-chart"></i> MONTHLY SALES REPORT</h4></span>
    </div>
    <hr/>

</div>

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-search-container">    
      <?php echo $this->render('_search-monthly-sales'); ?>
    </div> 
    
</div>
<br/>

<div class="col-md-12 col-sm-12 col-xs-12">
<br/>

    <table id="tbldesign" class="table table-striped table-boardered table-hover reportsTable responsive-utilities jambo_table">
        
        <thead>
            <tr class="headings">
                <th class="tblalign_center" ><b>INVOICE NUMBER</b></th>
                <th class="tblalign_center" ><b>TOTAL SELLING PRICE</b></th>
                <th class="tblalign_center" ><b>CUSTOMER NAME</b></th>
                <th class="tblalign_center" ><b>CUSTOMER AMOUNT PAID</b></th>
                <th class="tblalign_center" ><b>DATE ISSUE</b></th>
            </tr>
        </thead>
        <tbody>
        	<?php if( !empty($getMonthlySales) ): ?>
                <?php foreach( $getMonthlySales as $row){ ?>
                    <tr >
                        <td class="tblalign_center" ><?php echo $row['invoice_no'];  ?></td>
                        <td  class="tblalign_center" ><b><?php echo '$'.$row['grand_total'].'.00';  ?></b></td>
                        <td class="tblalign_center" ><?php echo $row['customerName'];  ?></td>
                        <td  class="tblalign_center" ><b><?php echo '$'.$row['amount'].'.00';  ?></b></td>
                        <td  class="tblalign_center" ><b><?php echo date('m-d-Y', strtotime($row['date_issue']) );  ?></b></td>
                    </tr>
                <?php } ?> 
            <?php else: ?>
                <tr>
                    <td><span>No Record Found.</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endif; ?> 
        </tbody>

    </table>
 
</div>

<div style="color:#fff">|</div>
<div ><hr/></div>

<div class="btnreportsAlign" >
    <p>
        <?php $form = ActiveForm::begin(['action' => '?r=reports/print-monthly-sales-report-excel', 'method' => 'post']); ?>
            <input type="hidden" id="date_start" value="<?= $date_start ?>" name="dateStart" />
            <input type="hidden" id="date_end" value="<?= $date_end ?>" name="dateEnd" />
         <button type="submit" class="form-btn btn btn-dark btn-lg" onclick="return excelPrintConfirmation()" >
            <i class="fa fa-download"></i> <b> Print to Excel </b>
         </button>
        <?php ActiveForm::end(); ?>
    </p>
    &nbsp;
</div>

</div>
<br/>

















