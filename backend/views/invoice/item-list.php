<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>  

<div class="row item-<?= $n ?>">
    <div class="col-md-6">
        <?php if ( $itemType == '0' ) {  ?>
            <b> <input type="checkbox" name="InvoiceDetail[task][]" id="task" class="task" value="<?= $serviceId ?>" /> Pending Service ?</b>
        <?php } ?>
    </div>

    <div class="col-md-6">
        <div style="text-align: right;">
            <span class="edit-button<?= $n ?> edit-button">
                <a href="javascript:editInvSelectedItem(<?= $n ?>)" id="invEditItemList" ><i class="fa fa-pencil"></i> Edit</a>
            </span>
            <span class="save-button<?= $n ?> save-button hidden">
                <a href="javascript:saveInvSelectedItem(<?= $n ?>)" id="invSaveItemList" ><i class="fa fa-save"></i> Save</a>
            </span>
            <span class="remove-button">
                <a href="javascript:removeInvSelectedItem(<?= $n ?>)" id="invDeleteItemList" >&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
            </span>
        </div>
    </div>
</div>
<div class="row item-<?= $n ?>">
    
    <div class="col-md-3">
        <?php if ( $itemType == '0' ) {  ?>
                <input type="text" class="form_invSP form-control" id="selected-<?= $n ?>-service" value=" <?= $serviceName ?>" readonly>
                <input type="hidden" class="form-control" name="InvoiceDetail[service_part_id][]" value="0-<?= $serviceId ?>" readonly>

            <?php } else { ?>
                <input type="text" class="form_invSP form-control" id="selected-<?= $n ?>-part" value="<?= $partName ?>" readonly>
                <input type="hidden" class="form-control" name="InvoiceDetail[service_part_id][]" value="1-<?= $partId ?>" readonly>

            <?php } ?>
    </div>

    <div class="col-md-3">
        <input type="text" class="form_invSP form-control" id="selected-<?= $n ?>-itemQty" name="InvoiceDetail[quantity][]" value="<?= $itemQty ?>" readonly onchange="updateInvSelectedItemSubtotal(<?= $n ?>)">
    </div>

    <div class="col-md-3">
        <input type="text" class="form_invSP form-control" id="selected-<?= $n ?>-itemPrice" name="InvoiceDetail[selling_price][]" value="<?= $itemPriceValue ?>" readonly onchange="updateInvSelectedItemSubtotal(<?= $n ?>)">
    </div>

    <div class="col-md-3">
         <input type="text" class="form_invSP form-control subTotalGroup" id="selected-<?= $n ?>-subTotal" name="InvoiceDetail[subTotal][]" value="<?= $itemSubTotal ?>" readonly>
    </div>


</div>