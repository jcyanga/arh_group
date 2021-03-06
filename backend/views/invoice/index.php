<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

// use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchCustomer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Invoice';

?>

<div style="text-align: right;" class="other-btns-container">
<br/>

    <p>
        <a href="?r=invoice/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-plus-circle"></i> <b> New Invoice </b>
        </a>

        <a href="?r=invoice/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Print to Excel </b>
        </a>
    </p>
</div>

<div class="row table-container">

<div>
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
            <h5 class="alert-heading"><i class="fa fa-info-circle"></i> <?= Yii::$app->session->getFlash('success'); ?></h5>
        </div>
    <?php endif; ?>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-qrcode"></i> Invoice</h4></span>
    </div>
    <hr/>

    <div class="form-search-container">    
      <?php echo $this->render('_search', [
                            'model' => $searchModel, 
                            'date_start' => $date_start, 
                            'date_end' => $date_end,
                            'customerName' => $customerName,
                            'vehicleNumber' => $vehicleNumber,
                        ]); ?>
    </div> 
    
</div>

 <div class="col-md-12 col-sm-12 col-xs-12">

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" ><b>DATE ISSUE</b></th>
            <th class="tblalign_center" ><b>CUSTOMER NAME</b></th>
            <th class="tblalign_center" ><b>VEHICLE NUMBER</b></th>
            <th class="tblalign_center" ><b>PAID</b></th>
            <th class="no-link last tblalign_center" ><span class="nobr">RECORD ACTION</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getInvoice) ): ?>
            <?php foreach( $getInvoice as $row){ ?>
                <tr class="even_odd pointer">
                    <!-- <td class="first tblalign_center">
                        <?php if( $row['status'] <> 1 ): ?>
                            <a href="?r=invoice/payment-method&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Proceed" >
                                 <b style="font-size: 11px;">Process Payment</b>
                            </a>
                        <?php else: ?>
                            <a href="?r=invoice/preview&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Print Processed Invoice?">
                                <li class="fa fa-print"></li>
                                <li class="fa fa-print"></li>
                                <li class="fa fa-print"></li>
                            </a>
                        <?php endif; ?>
                    </td> -->
                    <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($row['date_issue']) );  ?></td>
                    <td class="tblalign_center" ><?php echo $row['fullname'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['carplate'];  ?></td>
                    <td class="tblalign_center" style="font-style: italic;" ><?php echo ( $row['paid'] == 1 )? 'Yes' : 'Not Yet';  ?></td>
                    <td class="last tblalign_center">
                        <a href="?r=invoice/view&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Record" ><li class="fa fa-eye"></li> </a>
                        <?php if( $row['paid'] == 0 ): ?>
                           | <a href="?r=invoice/update&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit Record" ><li class="fa fa-edit"></li> </a> |
                           <a href="?r=invoice/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()" data-toggle="tooltip" data-placement="top" title="Delete Record" ><li class="fa fa-trash"></li> </a>
                        <?php endif; ?>
                    </td>
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

<div style="color:#fff">|<br/>|<br/>|<br/></div>

</div>

















