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

$this->title = 'Inventories';

?>

<div style="text-align: right;" class="other-btns-container">
<br/>

    <p>
        <a href="?r=quotation/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-cogs"></i> <b> New Quotation </b>
        </a>

        <a href="?r=quotation/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Export to Excel </b>
        </a>

        <a href="?r=quotation/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-pdf-o"></i> <b> Export to PDF </b>
        </a>
    </p>
</div>

<div class="row table-container">

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-pencil-square-o"></i> QUOTATION</h4></span>
    </div>
    <hr/>

 </div>

 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/><br/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr style="font-size: 11px;" class="headings">
            <th> # </th>
            <th class="tblalign_center" ><b>QUOTATION CODE</b></th>
            <th class="tblalign_center" ><b>BRANCH</b></th>
            <th class="tblalign_center" ><b>CUSTOMER NAME</b></th>
            <th class="tblalign_center" ><b>CAR-PLATE</b></th>
            <th class="tblalign_center" ><b>SALES PERSON</b></th>
            <th style="text-align: center;" class=" no-link last"><span class="nobr">RECORD ACTION</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getQuotation) ): ?>
            <?php foreach( $getQuotation as $row){ ?>
                <tr style="font-size: 11px; text-transform: uppercase;" class="even_odd pointer">
                    <td class=" "><?php echo $row['id'];  ?></td>
                    <td class="tblalign_center"><?php echo $row['quotation_code'];  ?></td>
                    <td class="tblalign_center"><?php echo $row['name'];  ?></td>
                    <td class="tblalign_center"><?php echo $row['fullname'];  ?></td>
                    <td class="tblalign_center"><?php echo $row['carplate'];  ?></td>
                    <td class="tblalign_center"><?php echo $row['salesPerson'];  ?></td>
                    <td style="text-align: center; font-size: 13px;" class=" last">
                       <a href="?r=quotation/view&id=<?php echo $row['id']; ?>"><li class="actionTooltip fa fa-eye"><span class="actionTooltiptext">View record</span></li> </a> |
                       <a href="?r=quotation/update&id=<?php echo $row['id']; ?>"><li class="actionTooltip fa fa-edit"><span class="actionTooltiptext">Update record</span></li> </a> |
                       <a href="?r=quotation/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()"><li class="actionTooltip fa fa-trash"><span class="actionTooltiptext">Delete record</span></li> </a>
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
                <td></td>
            </tr>
        <?php endif; ?> 
    </tbody>
    </table>
 
</div>

<div style="color:#fff">|<br/>|<br/>|<br/></div>

</div>

<br/>

















