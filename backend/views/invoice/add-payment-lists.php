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
                    <a href="javascript:removePayment(<?= $n ?>)"><button type="button" class="form-btn btn btn-link"><i class="fa fa-times-circle"></i> REMOVE  </button></a>
                </span>
      
        </div>

    </div> 
   
    <div class="row " >

        <div class="col-md-5">
            <span class="pmLabel" ><center> MODE OF PAYMENT  </center></span>
            <span class="modePayment" ><center> <?= $mPayment_type ?> </center></span>

            <input type="hidden" name="Payment[mlPayment_type][]" class="form_pm form-control" id="payment-<?= $n ?>-mPayment_type" value="<?= $mPayment_type ?>" readonly />
        </div>

        <div class="col-md-2">
            <span class="dots" >............................</span>
        </div>

        <div class="col-md-5">
            <span class="pmLabel" ><center> AMOUNT PAID  </center></span>
            <span class="amountPaid"><center> <?= $mAmount . '.00' ?> </center></span>

            <input type="hidden" name="Payment[mlAmount][]" class="form_pm form-control" id="payment-<?= $n ?>-mAmount" value="<?= $mAmount ?>" readonly />
        </div>

    </div>
 
    <div class="row transactionFormAlign" >

        <div class="col-md-3">
            <input type="hidden" name="Payment[mlDiscount][]" class="form_pm form-control" id="payment-<?= $n ?>-mDiscount" value="<?= $mDiscount ?>"  />
        </div>

        <div class="col-md-3">
            
            <input type="hidden" class="form_pm form-control" id="payment-<?= $n ?>-mPoints_redeem" name="Payment[mlPoints_redeem][]" value="<?= $mPoints_redeem ?>"  />
        </div>

        <div class="col-md-3">

            <input type="hidden" name="Payment[mlPoints_earned][]" class="form_pm form-control" id="payment-<?= $n ?>-mPoints_earned" value="<?= $mPoints_earned ?>"  />
        </div>

        <div class="col-md-3">

            <input type="hidden" name="Payment[mlRemarks][]" class="form_pm form-control" id="payment-<?= $n ?>-mRemarks" value="<?= $mRemarks ?>"  />

        </div>

    </div>

</div>
<hr/>