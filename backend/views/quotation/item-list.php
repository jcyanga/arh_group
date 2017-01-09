<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>

<div class="row">

    <div class="col-md-12">
        
        <table id="tblitemList" class="table table-boaredered">
            <?php if ( $itemType == '0' ) {  ?>
            <tr class="item-<?= $n ?>">    
                <td>
                    <b> <input type="checkbox" name="QuotationDetail[task][]" id="task" class="form_quoSP task"  value="checked" /> Pending Service ?</b>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>
            <tr class="item-<?= $n ?>">
                <td>
                    <?php if ( $itemType == '0' ) {  ?>
                        <input type="text" class="form_quoSP form-control" id="selected-<?= $n ?>-service" value=" <?= $serviceName ?>" readonly>
                        <input type="hidden" class="form-control" name="QuotationDetail[service_part_id][]" value="0-<?= $serviceId ?>" readonly>

                    <?php } else { ?>
                        <input type="text" class="form_quoSP form-control" id="selected-<?= $n ?>-part" value="<?= $partName ?>" readonly>
                        <input type="hidden" class="form-control" name="QuotationDetail[service_part_id][]" value="1-<?= $partId ?>" readonly>

                    <?php } ?>
                </td>
                <td>
                    <input type="text" class="form_quoSP form-control" id="selected-<?= $n ?>-itemQty" name="QuotationDetail[quantity][]" value="<?= $itemQty ?>" readonly onchange="updateSelectedItemSubtotal(<?= $n ?>)">
                </td>
                <td>
                    <input type="text" class="form_quoSP form-control" id="selected-<?= $n ?>-itemPrice" name="QuotationDetail[selling_price][]" value="<?= $itemPriceValue ?>" readonly onchange="updateSelectedItemSubtotal(<?= $n ?>)">
                </td>
                <td>
                    <input type="text" class="form_quoSP form-control subTotalGroup" id="selected-<?= $n ?>-subTotal" name="QuotationDetail[subTotal][]" value="<?= $itemSubTotal ?>" readonly>
                </td>
                <td>
                    <span class="edit-button<?= $n ?> edit-button">
                        <a href="javascript:editSelectedItem(<?= $n ?>)"><i class="fa fa-pencil"></i> Edit</a>
                    </span>
                    <span class="save-button<?= $n ?> save-button hidden">
                        <a href="javascript:saveSelectedItem(<?= $n ?>)"><i class="fa fa-save"></i> Save</a>
                    </span>
                    <span class="remove-button">
                        <a href="javascript:removeSelectedItem(<?= $n ?>)">&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
                    </span>
                </td>
            </tr>
        </table>
    
    </div>
</div>
