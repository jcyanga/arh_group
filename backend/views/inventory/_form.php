<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Supplier;
use common\models\Product;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'supplier_name');
$dataProduct = ArrayHelper::map(Product::find()->all(), 'id', 'product_name');
$getSupplier = Supplier::find()->all();

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Parts Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">Parts-Supplier</label>
        <br/>
        <select name="Inventory[supplier_id][]" class="form_input form-control select2_single" id="inventorySupplier" >
            <option value="0">CHOOSE SUPPLIER HERE</option>
            <?php foreach( $getSupplier as $sRow ): ?>
                <option value="<?php echo $sRow['id']; ?>"> <?php echo $sRow['supplier_name']; ?> </option>
            <?php endforeach; ?>
        </select>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label class="form_label">Product Name</label>
        <br/>
        <select name="Inventory[product][]" class="form_input form-control select2_single" id="inventoryProduct" >
            <option value="0">CHOOSE PARTS HERE</option>
            <?php foreach( $getProductList as $row ): ?>
                <option value="<?php echo $row['id']; ?>">[ <?php echo $row['category']; ?> ] <?php echo $row['product_name']; ?></option>
            <?php endforeach; ?>
        </select>

    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label class="form_label">Quantity</label>
        <input type="text" name="Inventory[quantity][]" class="form_input form-control" id="inventoryQty" placeholder="Write Quantity Here." />
    </div>

    <div class="col-md-3">
        <label class="form_label">Cost Price</label>
        <input type="text" name="Inventory[cost_price][]" class="form_input form-control" id="inventoryCost" placeholder="Write Cost Price Here." />
    </div>

    <div class="col-md-3">
        <label class="form_label">Selling Price</label>
        <input type="text" name="Inventory[selling_price][]" class="form_input form-control" id="inventorySelling" placeholder="Write Selling Price Here." />
    </div>

    <div class="col-md-3">
        <div style="padding-top: 30px;">
        <button type="button" class="form-btn btn btn-link" onclick="newProduct()"><i class="fa fa-plus"></i> Add Product </button>
        </div>  
    </div>

    <div >
        <input type="hidden" id="n" value="0" />
        <?= $form->field($model, 'created_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'date_imported')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'created_by')->textInput(['type' => 'hidden', 'value' => $userId])->label(false) ?>
    </div>

</div>
<br/>

<div class="selected-product-list" id="selected-product-list"></div>

<hr/>

<div class="row">

    <div class="col-md-4">
        <?= Html::submitButton($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Update Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>

<?php ActiveForm::end(); ?>


