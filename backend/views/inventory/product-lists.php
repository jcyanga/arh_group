<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>  

<div class="product-<?= $n ?>">

<div class="row">
	<div class="col-md-12">
		<div style="text-align: right;">
        	<a href="javascript:removeProduct(<?= $n ?>)" class="form-btn btn btn-link"><i class="fa fa-trash"></i> Remove</a>
    	</div>
    </div>
</div>

<div class="row">

	<div class="col-md-3">
        
        <label class="form_label">Supplier Name</label>

        <input type="text" class="form_input form-control" id="product-<?= $n ?>-suppliername" value="<?= $inventorySupplierName ?>" readonly />
        <input type="hidden" name="Inventory[supplier_id][]" class="form_input form-control" id="product-<?= $n ?>-supplierid" value="<?= $inventorySupplier ?>" />

    </div>  

    <div class="col-md-3">
        
        <label class="form_label">Product Name</label>

        <input type="text" class="form_input form-control" id="product-<?= $n ?>-name" value="<?= $inventoryProductName ?>" readonly />
        <input type="hidden" name="Inventory[product][]" class="form_input form-control" id="product-<?= $n ?>-id" value="<?= $inventoryProduct ?>" />

    </div>  

    <div class="col-md-2">
        <label class="form_label">Quantity</label>
        <input type="text" name="Inventory[quantity][]" class="form_input form-control" id="product-<?= $n ?>-quantity" value="<?= $inventoryQty ?>" readonly />
    </div>

    <div class="col-md-2">
        <label class="form_label">Cost Price</label>
        <input type="text" name="Inventory[cost_price][]" class="form_input form-control" id="product-<?= $n ?>-costPrice" value="<?= $inventoryCost ?>" readonly />
    </div>

    <div class="col-md-2">
        <label class="form_label">Selling Price</label>
        <input type="text" name="Inventory[selling_price][]" class="form_input form-control" id="product-<?= $n ?>-sellingPrice" value="<?= $inventorySelling ?>" readonly />
    </div>
    
</div>

</div>