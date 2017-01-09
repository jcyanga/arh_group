<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Branch;
use common\models\Supplier;
use common\models\Product;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'supplier_name');
$dataProduct = ArrayHelper::map(Product::find()->all(), 'id', 'product_name');
$quotationCode = 'QUO' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);
$quotationCodeValue = $quotationCode . $quotationId;

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="quotationHeader" >
        <span class="quotationHeaderLabel" > <li class="fa fa-info"></li> Customer Information </span>
    </div>

</div>
<br/>

<div style="margin: 0 auto;" class="row">

    <div class="col-md-6">
        <div class="row">

            <div class="col-md-6">

                <span class="quotationLabel" ><i class="fa fa-barcode"></i> Quotation Code </span>

                <input type="text" name="Quotation[quotationCode]" value="<?php echo $quotationCodeValue; ?>" class="form_qRInput form-control" id="quotationCode" readonly="readonly" />
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <div class="row">

        <div class="col-md-6">

            <span class="quotationLabel" ><i class="fa fa-calendar"></i> Date Issue </span>

            <input type="text" name="Quotation[dateIssue]" id="expiry_date" class="form_qRInput form-control" readonly="readonly" placeholder="CHOOSE DATE HERE" />    
        </div>

        </div>
    </div>
    
</div>
<br/>

<div style="margin: 0 auto;" class="row">

    <div class="col-md-6">
        <div class="row">

            <div class="col-md-7">
                
                <span class="quotationLabel" ><i class="fa fa-globe"></i> Branch </span>

                <select name="Quotation[selectedBranch]" class="qSelect select3_single">
                    <option value="0">SEARCH BRANCH HERE.</option>
                    <?php foreach( $getBranchList as $row ): ?>
                        <option value="<?php echo $row['id']; ?>">[ <?php echo $row['code']; ?> ] <?php echo $row['branchList']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <div class="row">

        <div class="col-md-7">
                
                <span class="quotationLabel" ><i class="fa fa-credit-card"></i> Plate No. or <i class="fa fa-user"></i> Customer Name</span>
                
                <select name="Quotation[selectedCustomer]" class="qSelect select3_single" >
                    <option value="0">SEARCH CUSTOMER BY PLATE NO. / NAME HERE.</option>
                    <?php foreach( $getCustomerList as $row ): ?>
                        <option value="<?php echo $row['id']; ?>">[ <?php echo $row['carplate']; ?> ] <?php echo $row['customerList']; ?></option>
                    <?php endforeach; ?>
                </select>   
        </div>

        </div>
    </div>
    
</div>
<br/>

<div style="margin: 0 auto;" class="row">

    <div class="col-md-6">
        <div class="row">

            <div class="col-md-7">
                
                <span class="quotationLabel" ><i class="fa fa-user"></i> Sales Person </span>

                <select name="Quotation[selectedUser]" class="qSelect select3_single" >
                    <option value="0">SEARCH SALES PERSON HERE.</option>
                    <?php foreach( $getUserList as $row ): ?>
                        <option value="<?php echo $row['id']; ?>">[ <?php echo $row['role']; ?> ] <?php echo $row['userList']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
    </div>
    
</div>
<br/>

<div style="margin: 0 auto;" class="row">

    <div class="col-md-5">
        
        <span class="quotationLabel" ><i class="fa fa-comment"></i> Remarks </span>
        <textarea name="Quotation[remarks]" placeholder="Write your remarks here." id="message" class="qtxtarea form-control" data-parsley-trigger="keyup" data-parsley-minlength="10" data-parsley-maxlength="100" data-parsley-minlength-message="You need to enter at least a 10 caracters long comment." data-parsley-validation-threshold="10"></textarea> 
    </div>
    
</div>
<br/><br/>

<div class="row">

    <div class="quotationHeader" >
        <span class="quotationHeaderLabel" > <li class="fa fa-info"></li> Services or Parts Information </span>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-4">

        <div style="text-align: center; "> <b><span><i class="fa fa-battery-quarter"></i> Services | <i class="fa fa-cogs"></i> Parts </span></b> </div>
        <br/>
        <select class="select2_group form-control" id="services_parts" onchange="quoGetSellingPrice()" >
            <option value="0">SEARCH PARTS OR SERVICES</option>
            
            <optgroup label="- SERVICES - ">
                <?php foreach($getServicesList as $srowList): ?>
                    <option value="0-<?php echo $srowList['id']; ?>">[ <?php echo $srowList['name']; ?> ] <?php echo $srowList['service_name']; ?></option>                 
                <?php endforeach; ?>
             </optgroup>

             <optgroup label="- PARTS - ">
                <?php foreach($getPartsList as $prowList): ?>
                    <option value="1-<?php echo $prowList['id']; ?>">[ <?php echo $prowList['category']; ?> ] <?php echo $prowList['product_name']; ?></option>                 
                <?php endforeach; ?>
             </optgroup>      
        
        </select>

    </div>

    <div class="col-md-2">
        
        <div class="quoSPLabel"> <b><span><i class="fa fa-database"></i> Quantity </span></b> </div>
        <br/>
        <input type="text"  id="itemQty" onchange="quoUpdateSubTotal()" class="quantity form_quoSP form-control" placeholder="Qty" />

    </div>

    <div class="col-md-2">

        <div class="quoSPLabel"> <b><span><i class="fa fa-usd"></i> Selling Price </span></b> </div>
        <br/>
        <input type="text" id="itemPriceValue" onchange="quoUpdateSubTotal()" class="unit_price form_quoSP form-control" placeholder="0.00" />

    </div>

    <div class="col-md-2">
        
        <div class="quoSPLabel"> <b><span><i class="fa fa-money"></i> Sub-Total </span></b> </div>
        <br/>
        <input type="text" id="itemSubTotal" class="sub_total form_quoSP form-control" readonly="readonly" placeholder="0.00" />
    </div>

    <div class="col-md-2">
        <div class="quoSPLabel"> <b><span><i class="fa fa-bars"></i> Action </span></b> </div>
        <br/>
        <div class="quoSPAction">
            <a href="javascript:quoAddItemList()" id="quoAddItemList" class="form-btn btn btn-default" ><i class='fa fa-plus-circle'></i> Add Item in List </a>
        </div>
    </div>
    
</div>
<br/>

<table class="selected-item-list table table-boardered tblselecteditemList" id="selected-item-list"></table><br/>

<div class="row">

    <div class="col-md-4"></div>

    <div class="col-md-2"></div>

    <div class="col-md-2"></div>

    <div class="col-md-2"></div>

    <div class="col-md-2">
        <input type="text" name="Quotation[grand_total]" class="grandTotal form_quoSP form-control" id="grandTotal" style="text-align: center;" placeholder="Grand Total" readonly />
    </div>
    
</div>

<input type="hidden" id='n' value="0">
<br/>

<hr/>

<div class="row">

    <div class="col-md-12">
        <div style="text-align: right;">        
        <?= Html::submitButton('<li class=\'fa fa-save\'></li> Submit Quotation' , ['class' =>'form-btn btn btn-success']) ?>
        <?= Html::resetButton('<li class=\'fa fa-file\'></li> Cancel', ['class' => 'form-btn btn btn-danger']) ?>
        </div>
    </div>

</div>
<br/><br/>

<?php ActiveForm::end(); ?>









    

