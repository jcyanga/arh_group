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
                    <a href="javascript:removePayment(<?= $n ?>)"><button type="button" class="form-btn btn btn-link pull-right"><i class="fa fa-times-circle"></i> REMOVE  </button></a>
                </span>
        </div>
    </div> 
   
    <div class="row " >

        <div class="col-md-4">
            <span class="pmLabel" ><center> MODE OF PAYMENT  </center></span>
            <span class="modePayment" ><center> <?= $mPayment_type_name ?> </center></span>

            <input type="hidden" name="Payment[mlPayment_type][]" class="form_pm form-control mPayment_type" id="payment-<?= $n ?>-mPayment_type" value="<?= $mPayment_type ?>" readonly />
        </div>

        <div class="col-md-3">
            <span class="pmLabel" ><center> POINTS REDEEM  </center></span>
            <span class="amountDiscounts"><center> <?= $mPoints_redeem ?> </center></span>

            <input type="hidden" name="Payment[mlPoints_redeem][]" class="form_pm form-control mPoints_redeem" id="payment-<?= $n ?>-mPoints_redeem" value="<?= $mPoints_redeem ?>" readonly />
        </div>

        <div class="col-md-3">
            <span class="pmLabel" ><center> AMOUNT PAID  </center></span>
            <span class="amountPaid"><center> $<?= $mAmount ?> </center></span>

            <input type="hidden" name="Payment[mlAmount][]" class="form_pm form-control mAmount" id="payment-<?= $n ?>-mAmount" value="<?= $mAmount ?>" readonly />
        </div>

    </div>
 
    <div class="row transactionFormAlign" >
        <div class="col-md-3">
            <input type="hidden" name="Payment[mlRemarks][]" class="form_pm form-control mRemarks" id="payment-<?= $n ?>-mRemarks" value="<?= $mRemarks ?>"  />
        </div>
    </div>

</div>
<hr/>