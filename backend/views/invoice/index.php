<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\Inventory;
use common\models\Supplier;
use common\models\Product;

use yii\db\Query;

$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'supplier_name');

$rows = new Query();

$dataProduct = ArrayHelper::map($rows->select(['id', "concat(product_code, ' - ' ,product_name) as product_name"])
            ->from('product')
            ->all(),
             'id', 'product_name');

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
            <i class="fa fa-desktop"></i> <b> New Invoice </b>
        </a>

        <a href="?r=invoice/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Print to Excel </b>
        </a>
    </p>
</div>

<div class="row table-container">

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-desktop"></i> Invoice</h4></span>
    </div>
    <hr/>

    <div class="form-search-container">    
      <?php echo $this->render('_search', [
                            'model' => $searchModel, 
                            'date_start' => $date_start, 
                            'date_end' => $date_end
                        ]); ?>
    </div> 
    
</div>

 <div class="col-md-12 col-sm-12 col-xs-12">

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="no-link first tblalign_center" ><span class="nobr">INVOICE PAYMENT</span>
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
                    <td class="first tblalign_center">
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
                    </td>
                    <td class="tblalign_center" ><?php echo date('m-d-Y', strtotime($row['date_issue']) );  ?></td>
                    <td class="tblalign_center" ><?php echo $row['fullname'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['carplate'];  ?></td>
                    <td class="tblalign_center" style="font-style: italic;" ><?php echo ( $row['paid'] == 1 )? 'Yes' : 'Not Yet';  ?></td>
                    <td class="last tblalign_center">
                        <a href="?r=invoice/view&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Record" ><li class="fa fa-eye"></li> </a>
                        <?php if( $row['status'] <> 1 ): ?>
                           | <a href="?r=invoice/update&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="Update Record" ><li class="fa fa-edit"></li> </a> |
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
                <td></td>
            </tr>
        <?php endif; ?> 
    </tbody>
    </table>
 
</div>

<div style="color:#fff">|<br/>|<br/>|<br/></div>

</div>

<br/>

















