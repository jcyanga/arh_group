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
            <i class="fa fa-file-excel-o"></i> <b> Print to Excel </b>
        </a>

        <a href="?r=inventory/export-pdf" id="option-list-link" onclick="return pdfPrintConfirmation()" class="btn btn-app">
            <i class="fa fa-file-pdf-o"></i> <b> Print to PDF </b>
        </a>
    </p>
</div>

<?php $form = ActiveForm::begin(['action' => '?r=inventory/update-qty', 'method' => 'POST', 'class' => 'form-inline']); ?>

<div class="row table-container">

<div>
    <?php if($msg <> ''){ ?>
        <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
            <?php echo $msg; ?>
        </div>
    <?php } ?>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-cogs"></i> Parts-Inventory</h4></span>
    </div>
    <hr/>

 </div>
 
 <div class="col-md-12 col-sm-12 col-xs-12">
 
 <div>
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
        <button type="button" name="btn-checkAll" class="form-btn btn btn-info " id="checkAllParts" ><i class="fa fa-check-square"></i> Select All</button>
        <button type="submit" name="btn-updateQty" class="form-btn btn btn-dark"><i class="fa fa-database"></i> Update Parts Quantity</button>
 </div>

</div> 

 <div class="col-md-12 col-sm-12 col-xs-12">
 <br/><br/>

    <table id="tbldesign" class="table table-striped responsive-utilities jambo_table">
    <thead>
        <tr class="headings">
            <th class="tblalign_center" > <i class="fa fa-check"></i> </th>
            <th class="tblalign_center" > # </th>
            <th class="tblalign_center" ><b>SUPPLIER</b></th>
            <th class="tblalign_center" ><b>PRODUCT CODE</b></th>
            <th class="tblalign_center" ><b>PRODUCT NAME</b></th>
            <th class="tblalign_center" ><b>QUANTITY</b></th>
            <th class="tblalign_center" ><b>COST PRICE</b></th>
            <th class="tblalign_center" ><b>SELLING PRICE</b></th>
            <th class="no-link last tblalign_center"><span class="nobr">RECORD ACTION</span>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php if( !empty($getProductInInventory) ): ?>
            <?php foreach( $getProductInInventory as $row){ ?>
                <tr class="even_odd pointer">
                    <td class="tblalign_center" ><input type="checkbox" name="updateQty[]" value="<?php echo $row['id'] . '|' . $row['product_name'] . '|' . $row['quantity'] . '|' . $row['product_id'] . '|' . $row['supplier_id'] . '|' . $row['cost_price'] . '|' . $row['selling_price'];  ?>" id="updateQty" class="updateQty" /></td>
                    <td class="tblalign_center" ><?php echo $row['id'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['supplier_name'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['product_code'];  ?></td>
                    <td class="tblalign_center" ><?php echo $row['product_name'];  ?></td>
                    <td class="tblalign_center" ><h5><b><?php echo $row['quantity'];  ?></b></h5></td>
                    <td class="tblalign_center" ><?php echo '$'.$row['cost_price'].'.00';  ?></td>
                    <td class="tblalign_center" ><b><?php echo '$'.$row['selling_price'].'.00';  ?></b></td>
                    <td class="last tblalign_center">
                       <a href="?r=inventory/view&id=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" title="View Record" ><li class="fa fa-eye"></li> </a> |
                       <a href="?r=inventory/delete-column&id=<?php echo $row['id']; ?>&product_id=<?php echo $row['product_id']; ?>&date_imported=<?php echo $row['date_imported']; ?>" onclick="return deleteConfirmation()" data-toggle="tooltip" data-placement="top" title="Delete Record" ><li class="fa fa-trash"></li> </a>
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

<?php ActiveForm::end(); ?>

<br/>
















