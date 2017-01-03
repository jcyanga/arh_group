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
            <i class="fa fa-pencil-square-o"></i> <b> New Quotation </b>
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
<br/>

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-pencil-square-o"></i> QUOTATION</h4></span>
    </div>
    <hr/>

 </div>

 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/><br/>

   
 
</div>

<div style="color:#fff">|<br/>|<br/>|<br/></div>

</div>

<br/>
















