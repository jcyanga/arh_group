<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>

<?php if(!empty($getParts)): ?>

    <?php foreach($getParts as $row): ?>
        <?php $subTotal = $row['quantity'] * $row['selling_price']; ?>     
        <div class="parts-item-<?= $row['id'] ?>">
            <input type="hidden" name="itemParts[]" id="parts-item-Products-<?= $row['id'] ?>" value="<?= $row['id'] ?>" class="parts-item-Products" />

            <input type="hidden" name="inventoryId" id="parts-item-productId-<?= $row['id'] ?>" value="<?= $row['id'] ?>" />

            <div class="col-md-3">
                        
                <div class="quoSPLabel"> <b><span><i class="fa fa-cogs"></i> Product Name </span></b> </div>
                <input type="text" id="parts-item-productName-<?= $row['id'] ?>" class="product_name form_quoSP form-control" value="<?= strtoupper($row['product_name']) ?>" readonly />
                <br/><br/>

            </div>

            <div class="col-md-3">

                <div class="quoSPLabel"> <b><span><i class="fa fa-database"></i> Quantity </span></b> </div>
                <input type="text"  id="parts-item-qty-<?= $row['id'] ?>" onchange="quoUpdatePartsSubTotal(<?= $row['id'] ?>)" class="quantity form_quoSP form-control" placeholder="0"  />
                <span style="color: #444;"><b>*Current Quantity: <?= $row['quantity'] ?></b></span>
                <br/><br/>

            </div>

            <div class="col-md-3">

                <div class="quoSPLabel"> <b><span><i class="fa fa-usd"></i> Unit Price </span></b> </div>
                <input type="text" id="parts-item-unitPrice-<?= $row['id'] ?>" onchange="quoUpdatePartsSubTotal(<?= $row['id'] ?>)" class="unit_price form_quoSP form-control" value="<?= $row['selling_price'] ?>" placeholder="0.00" />
                <br/><br/>

            </div>

            <div class="col-md-3">

                <div class="quoSPLabel"> <b><span><i class="fa fa-money"></i> Sub-Total </span></b> </div>
                <input type="text" id="parts-item-subTotal-<?= $row['id'] ?>" class="sub_total form_quoSP form-control" readonly="readonly" value="<?= $subTotal ?>" />
                <br/><br/>

            </div>

        </div>
    <?php endforeach; ?>

        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-3">
        <div class="quoSPAction pull-right">
            <a href="javascript:quoAddPartsToSelectedItem(<?= $row['id'] ?>)" id="quoAddItemList" class="form-btn btn btn-info btn-lg" ><i class='fa fa-cart-plus'></i> Add Product in List </a>
        </div>
        </div>

<?php endif; ?>
