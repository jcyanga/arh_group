<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>

<div class="row item-<?= $n ?>"> 
    <div class="col-md-3">
        <?php if ( $itemType == '0' || $itemType == '3' ) {  ?>
                <span class="selectedLabel"><center><?= strtoupper($serviceName) ?></center></span>
                <input type="hidden" class="form_quoSP form-control" id="selected-<?= $n ?>-service" value="<?= strtoupper($serviceName) ?>" readonly>
                <input type="hidden" class="servicePartId form-control" name="QuotationDetail[service_part_id][]" value="0-<?= $serviceName ?>" readonly>

            <?php } else { ?>
                <span class="selectedLabel"><center><?= strtoupper($partName) ?></center></span>
                <input type="hidden" class="form_quoSP form-control" id="selected-<?= $n ?>-part" value="<?= strtoupper($partName) ?>" readonly>
                <input type="hidden" class="servicePartId form-control" name="QuotationDetail[service_part_id][]" value="1-<?= $partId ?>" readonly>

            <?php } ?>
    </div>

    <div class="col-md-2">
        <span class="selectedLabel"><center><?= $itemQty ?></center></span>
        <input type="hidden" class="itemQty form_quoSP form-control" id="selected-<?= $n ?>-itemQty" name="QuotationDetail[quantity][]" value="<?= $itemQty ?>" readonly onchange="updateSelectedItemSubtotal(<?= $n ?>)">
    </div>

    <div class="col-md-2">
        <span class="selectedLabel"><center><?= $itemPriceValue ?></center></span>
        <input type="hidden" class="itemPriceValue form_quoSP form-control" id="selected-<?= $n ?>-itemPrice" name="QuotationDetail[selling_price][]" value="<?= $itemPriceValue ?>" readonly onchange="updateSelectedItemSubtotal(<?= $n ?>)">
    </div>

    <div class="col-md-2">
        <span class="selectedLabel"><center><?= $itemSubTotal ?></center></span>
         <input type="hidden" class="itemSubTotal form_quoSP form-control subTotalGroup" id="selected-<?= $n ?>-subTotal" name="QuotationDetail[subTotal][]" value="<?= $itemSubTotal ?>" readonly>
    </div>

    <div class="col-md-3">
        <?php if ( $itemType == '0' || $itemType == '3' ) {  ?>
            <b> <input type="checkbox" name="QuotationDetail[task][]" id="task" class="task" value="<?= $serviceName ?>" /> Pending Service ? | </b>
        <?php } ?>
        <span class="remove-button">
             <a href="javascript:removeSelectedItem(<?= $n ?>)" id="quoDeleteItemList">&nbsp;&nbsp;<i class="fa fa-trash"></i> <b>Remove</b> </a>
        </span>
    </div>

</div>
<div class="row item-<?= $n ?>"> <hr/></div>