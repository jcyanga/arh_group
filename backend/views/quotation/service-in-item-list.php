<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>

<?php if(!empty($getServices)): ?>

    <?php foreach($getServices as $row): ?>
        <?php $subTotal = $row['default_price']; ?>     
        <div class="service-item-<?= $row['id'] ?>">
            <input type="hidden" name="itemServices[]" id="service-item-Services-<?= $row['id'] ?>" value="<?= $row['id'] ?>" class="service-item-Services" />

            <input type="hidden" name="serviceId" id="service-item-serviceId-<?= $row['id'] ?>" value="<?= $row['id'] ?>" />

            <div class="col-md-3">
                        
                <div class="quoSPLabel"> <b><span><i class="fa fa-battery-quarter"></i> Service Name </span></b> </div>
                <input type="text" id="service-item-serviceName-<?= $row['id'] ?>" class="service_name form_quoSP form-control" value="<?= strtoupper($row['service_name']) ?>" readonly />
                <br/>

            </div>

            <div class="col-md-3">

                <div class="quoSPLabel"> <b><span><i class="fa fa-database"></i> Quantity </span></b> </div>
                <input type="text"  id="service-item-qty-<?= $row['id'] ?>" onchange="quoUpdateServiceSubTotal(<?= $row['id'] ?>)" class="quantity form_quoSP form-control" value="1" placeholder="Qty" />
                <br/>

            </div>

            <div class="col-md-3">

                <div class="quoSPLabel"> <b><span><i class="fa fa-usd"></i> Unit Price </span></b> </div>
                <input type="text" id="service-item-unitPrice-<?= $row['id'] ?>" onchange="quoUpdateServiceSubTotal(<?= $row['id'] ?>)" class="unit_price form_quoSP form-control" value="<?= $row['default_price'] ?>" placeholder="0.00" />
                <br/>

            </div>

            <div class="col-md-3">

                <div class="quoSPLabel"> <b><span><i class="fa fa-money"></i> Sub-Total </span></b> </div>
                <input type="text" id="service-item-subTotal-<?= $row['id'] ?>" class="sub_total form_quoSP form-control" readonly="readonly" value="<?= $subTotal ?>" />
                <br/>

            </div>

        </div>
    <?php endforeach; ?>

        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-3">
        <div class="quoSPAction pull-right">
            <a href="javascript:quoAddServiceToSelectedItem(<?= $row['id'] ?>)" id="quoAddItemList" class="form-btn btn btn-info btn-lg" ><i class='fa fa-cart-plus'></i> Add Service in List </a>
        </div>
        </div>

<?php endif; ?>
