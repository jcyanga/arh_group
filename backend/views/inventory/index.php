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
        <a href="?r=inventory/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-cogs"></i> <b> New Item in Inventory </b>
        </a>

        <a href="?r=product/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-chain"></i> <b> New Product </b>
        </a>

        <a href="?r=supplier/create" id="option-list-link" class="btn btn-app">
            <i class="fa fa-truck"></i> <b> New Supplier </b>
        </a>

        <a href="?r=inventory/export-excel" id="option-list-link" onclick="return excelPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-excel-o"></i> <b> Export to Excel </b>
        </a>

        <a href="?r=inventory/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-pdf-o"></i> <b> Export to PDF </b>
        </a>
    </p>
</div>

<div class="row table-container">
 
 <div class="col-md-12 col-sm-12 col-xs-12">
  
    <div>
        <?php if($msg <> ''){ ?>
            <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
            <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
                <?php echo $msg; ?>
            </div>
        <?php } ?>
    </div>

    <div class="form-title-container">
        <span class="form-header"><h4>PARTS INVENTORY</h4></span>
    </div>
    <hr/>

 </div>

 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/><br/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr style="font-size: 11px;" class="headings">
            <th> # </th>
            <th style="text-align: center;" ><b>SUPPLIER</b></th>
            <th style="text-align: center;" ><b>PRODUCT CODE</b></th>
            <th style="text-align: center;" ><b>PRODUCT NAME</b></th>
            <th style="text-align: center;" ><b>QUANTITY</b></th>
            <th style="text-align: center;" ><b>COST PRICE</b></th>
            <th style="text-align: center;" ><b>SELLING PRICE</b></th>
            <th style="text-align: center;" class=" no-link last"><span class="nobr">RECORD ACTION</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getProductInInventory) ): ?>
            <?php foreach( $getProductInInventory as $row){ ?>
                <tr style="font-size: 11px; text-transform: uppercase;" class="even_odd pointer">
                    <td class=" "><?php echo $row['id'];  ?></td>
                    <td style="text-align: center;" class=" "><?php echo $row['supplier_name'];  ?></td>
                    <td style="text-align: center;" class=" "><?php echo $row['product_code'];  ?></td>
                    <td style="text-align: center;" class=" "><?php echo $row['product_name'];  ?></td>
                    <td style="text-align: center;" class=" "><?php echo $row['quantity'];  ?></td>
                    <td style="text-align: center;" class=" "><?php echo $row['cost_price'];  ?></td>
                    <td style="text-align: center;" class=" "><?php echo $row['selling_price'];  ?></td>
                    <td style="text-align: center; font-size: 12px;" class=" last">
                        <a href="?r=inventory/view&id=<?php echo $row['id']; ?>"><b><li class="fa fa-eye"></li> VIEW </b></a> | 
                        <a href="?r=inventory/delete-column&id=<?php echo $row['id']; ?>" onclick="return deleteConfirmation()"><b><li class="fa fa-trash"></li> DELETE </b></a>
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
                <td></td>
            </tr>
        <?php endif; ?> 
    </tbody>
    </table>
 
</div>

<div style="color:#fff">|<br/>|<br/>|<br/></div>

</div>

<br/>
















