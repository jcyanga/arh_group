<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>  

<div class="payment-<?= $n ?>">

    <div class="row">

        <div class="col-md-12">
                
                <span class="remove-button">
                    <a href="javascript:removePayment(<?= $n ?>)"><button type="button" class="form-btn btn btn-link"><i class="fa fa-minus-circle"></i> REMOVE PAYMENT </button></a>
                </span>
      
        </div>

    </div> 
    <br/>

    <div style="margin-left: 10px;" class="row">

        <div class="col-md-4">
            <span class="pmLabel" ><i class="fa fa-bank"></i> MODE OF PAYMENT </span>

            <input type="text" name="Payment[mlPayment_type][]" class="form_pm form-control" id="payment-<?= $n ?>-mPayment_type" value="<?= $mPayment_type ?>" readonly />
        </div>

        <div class="col-md-4">
            <span class="pmLabel" ><i class="fa fa-money"></i> AMOUNT </span>

            <input type="text" name="Payment[mlAmount][]" class="form_pm form-control" id="payment-<?= $n ?>-mAmount" value="<?= $mAmount ?>" readonly />
        </div>

        <div class="col-md-4">
            <span class="pmLabel" ><i class="fa fa-minus-square"></i> DISCOUNT </span>

            <input type="text" name="Payment[mlDiscount][]" class="form_pm form-control" id="payment-<?= $n ?>-mDiscount" value="<?= $mDiscount ?>" readonly />
        </div>

    </div>
    <br/>

    <div style="margin-left: 10px;" class="row">

        <div class="col-md-4">
            <span class="pmLabel" ><i class="fa fa-user"></i> POINTS REDEEMED </span>
            
            <input type="text" class="form_pm form-control" id="payment-<?= $n ?>-mPoints_redeem" name="Payment[mlPoints_redeem][]" value="<?= $mPoints_redeem ?>" readonly />
        </div>

        <div class="col-md-4">
            <span class="pmLabel" ><i class="fa fa-dot-circle-o"></i> POINTS EARNED </span>

            <input type="text" name="Payment[mlPoints_earned][]" class="form_pm form-control" id="payment-<?= $n ?>-mPoints_earned" value="<?= $mPoints_earned ?>" readonly />
        </div>

    </div>
    <br/>

    <div style="margin-left: 10px;" class="row">

        <div class="col-md-11">
            <span class="pmLabel" ><i class="fa fa-comments"></i> REMARKS </span>

            <textarea cols="10" rows="2" name="Payment[mlRemarks][]" class="form_pmTxtArea form-control" id="payment-<?= $n ?>-mRemarks" readonly><?= $mRemarks ?></textarea>

        </div>

    </div>

</div>
<hr/>