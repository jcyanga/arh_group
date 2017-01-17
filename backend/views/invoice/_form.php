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
$invoiceCode = 'INVOICE' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);
$invoiceCodeValue = $invoiceCode . '-' . $invoiceId;

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row transactionform-container">

<div>
    <?php if($msg <> ''){ ?>
        <div class="alert <?php echo $errType; ?> alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><?php echo $errTypeHeader; ?></h4>
            <?php echo $msg; ?>
        </div>
    <?php } ?>
</div>

 <div class="col-md-12 col-sm-12 col-xs-12">
 
    <div class="form-title-container">
        <span class="form-header"><h4><i class="fa fa-pencil"></i> Create Invoice</h4></span>
    </div>
    <hr/>

    <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
    <br/><br/>

    <div class="form-crud-container">
        
        <div class="row invoiceHeader">
            <div class="col-md-12">
                
                <div >
                    <span class="invoiceHeaderLabel" > <li class="fa fa-info"></li> Customer Information </span>
                </div>
            
            </div>
        </div>
        <br/><br/>

        <div class="row transactionFormAlign" >

            <div class="col-md-6">
                <div class="row">

                    <div class="col-md-8">

                        <span class="invoiceLabel" ><i class="fa fa-barcode"></i> Invoice Number </span>

                        <input type="text" name="Invoice[invoice_no]" value="<?php echo $invoiceCodeValue; ?>" class="form_iRInput form-control" id="invoiceNo" readonly="readonly" />
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="row">

                <div class="col-md-8">

                    <span class="invoiceLabel" style="margin-left: 45px;" ><i class="fa fa-calendar"></i> Date Issue </span>

                    <input type="text" name="Invoice[dateIssue]" style="margin-left: 40px;" id="expiry_date" class="form_iRInput form-control" readonly="readonly" placeholder="CHOOSE DATE HERE" />    
                </div>

                </div>
            </div>
            
        </div>
        <br/><br/>

        <div class="row transactionFormAlign" >

        <div class="col-md-6">
            <div class="row">

                <div class="col-md-8">
                    
                    <span class="invoiceLabel" ><i class="fa fa-globe"></i> Branch </span>

                    <select name="Invoice[selectedBranch]" class="qSelect select3_single">
                        <option value="0">SEARCH BRANCH HERE.</option>
                        <?php if( !empty($getBranchList) ): ?>
                            <?php foreach( $getBranchList as $row ): ?>
                                <option value="<?php echo $row['id']; ?>">[ <?php echo $row['code']; ?> ] <?php echo $row['branchList']; ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="0">NO RECORD FOUND.</option>
                        <?php endif; ?>
                    </select>
                </div>

            </div>
        </div>
        
        </div>
        <br/>

        <div class="row transactionFormAlign" >

        <div class="col-md-6">
            <div class="row">

                <div class="col-md-8">
                    
                    <span class="invoiceLabel" ><i class="fa fa-users"></i> Customer Name</span>
                    
                    <select name="Invoice[selectedCustomer]" class="qSelect select3_single" >
                        <option value="0">SEARCH CUSTOMER HERE.</option>
                        <?php if( !empty($getCustomerList) ): ?>
                            <?php foreach( $getCustomerList as $row ): ?>
                                <option value="<?php echo $row['id']; ?>">[ <?php echo $row['carplate']; ?> ] <?php echo $row['customerList']; ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="0">NO RECORD FOUND.</option>
                        <?php endif; ?>
                    </select>   
                </div>

            </div>
        </div>
        
        </div>
        <br/>

        <div class="row transactionFormAlign" >

        <div class="col-md-6">
            <div class="row">

                <div class="col-md-8">
                    
                    <span class="invoiceLabel" ><i class="fa fa-user"></i> Sales Person </span>

                    <select name="Invoice[selectedUser]" class="qSelect select3_single" >
                        <option value="0">SEARCH SALES PERSON HERE.</option>
                        <?php if( !empty($getUserList) ): ?>
                            <?php foreach( $getUserList as $row ): ?>
                                <option value="<?php echo $row['id']; ?>"> <?php echo $row['userList']; ?> </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="0">NO RECORD FOUND.</option>
                        <?php endif; ?>
                    </select>
                </div>

            </div>
        </div>
        
        </div>
        <br/><br/>

        <div class="row transactionFormAlign" >

        <div class="col-md-6">
            
            <span class="invoiceLabel" ><i class="fa fa-comment"></i> Remarks </span>
            <textarea name="Invoice[remarks]" style="font-size: 11.5px;" placeholder="Write your remarks here." id="message" class="qtxtarea form-control" data-parsley-trigger="keyup" data-parsley-minlength="10" data-parsley-maxlength="300" data-parsley-minlength-message="You need to enter at least a 10 caracters long comment." data-parsley-validation-threshold="10"></textarea> 
        </div>
        
        </div>
        <br/>

    </div>   
 
 </div>

</div>


<div class="row transactionform-container">

 <div class="col-md-12 col-sm-12 col-xs-12">
 
    <div class="form-crud-container">
        
        <div class="row invoiceHeader">
            <div class="col-md-12">
                
                <div >
                    <span class="invoiceHeaderLabel" > <li class="fa fa-chain-broken"></li> Services or Parts Information </span>
                </div>
            
            </div>
        </div>
        <br/><br/>

        <div class="row transactionFormAlign" >

        <div class="col-md-5">

            <div style="text-align: center;"> <b><span><i class="fa fa-battery-quarter"></i> Services | <i class="fa fa-cogs"></i> Parts </span></b> 
            </div>

            <select class="select2_group form-control" id="services_parts" onchange="invGetSellingPrice()" >
                <option value="0">SEARCH PARTS OR SERVICES</option>
                
                <optgroup label="- SERVICES - ">
                    <?php if( !empty($getServicesList) ): ?>
                        <?php foreach($getServicesList as $srowList): ?>
                            <option value="0-<?php echo $srowList['id']; ?>">[ <?php echo $srowList['name']; ?> ] <?php echo $srowList['service_name']; ?></option>                 
                        <?php endforeach; ?>
                    <?php else: ?>
                            <option value="0">NO RECORD FOUND.</option>
                    <?php endif; ?>
                 </optgroup>

                 <optgroup label="- PARTS - ">
                    <?php if( !empty($getPartsList) ): ?>
                        <?php foreach($getPartsList as $prowList): ?>
                            <option value="1-<?php echo $prowList['id']; ?>">[ <?php echo $prowList['supplier_name']; ?> | <?php echo $prowList['category']; ?> ] <?php echo $prowList['product_name']; ?></option>                 
                        <?php endforeach; ?>
                    <?php else: ?>
                            <option value="0">NO RECORD FOUND.</option>
                    <?php endif; ?>
                 </optgroup>      
            
            </select>

        </div>
        
        </div>
        <br/>

        <div class="row transactionFormAlign" >
            
            <div class="col-md-3">
        
                <div class="invSPLabel"> <b><span><i class="fa fa-database"></i> Quantity </span></b> </div>
    
                <input type="text"  id="itemQty" onchange="invUpdateSubTotal()" class="quantity form_invSP form-control" placeholder="Qty" />

            </div>

            <div class="col-md-3">
        
                <div class="invSPLabel"> <b><span><i class="fa fa-usd"></i> Selling Price </span></b> </div>
           
                <input type="text" id="itemPriceValue" onchange="invUpdateSubTotal()" class="unit_price form_invSP form-control" placeholder="0.00" />

            </div>

            <div class="col-md-3">
        
                <div class="invSPLabel"> <b><span><i class="fa fa-money"></i> Sub-Total </span></b> </div>
                
                <input type="text" id="itemSubTotal" class="sub_total form_invSP form-control" readonly="readonly" placeholder="0.00" />

            </div>

            <div class="col-md-3">
        
                <div class="invSPLabel"> <b><span><i class="fa fa-bars"></i> Action </span></b> </div>
               
                <div class="quoSPAction">
                    <a href="javascript:invAddItemList()" id="invAddItemList" class="form-btn btn btn-link" ><i class='fa fa-plus-circle'></i> Add Item in List </a>
                </div>

            </div>

        </div>
        <br/>

        <div id="invSelectedContainer" class="row transactionFormAlign" >
            
            <div class="col-md-12">
                <b><i class="fa fa-thumbs-up"></i> Selected Services or Parts</b>
            </div>
            <hr/>
            
            <div class="col-md-12">
                <div class="selected-item-list" id="selected-item-list"></div><br/>
            </div>
        </div>
        <br/>

        <div class="row transactionFormAlign" >

            <div class="col-md-4"></div>

            <div class="col-md-3"></div>

            <div class="col-md-3"></div>

            <div class="col-md-2">
                <input type="text" name="Invoice[grand_total]" class="grandTotal form_invSP form-control" id="grandTotal" style="text-align: center;" placeholder="Total Price" readonly />
            </div>
        
        </div>
        
        <input type="hidden" id='n' value="0">
        <br/>

    </div>   
 
 </div>

</div>
<br/>

<div class="row">

    <div class="col-md-12">
        <div style="text-align: right;">        
        <?= Html::submitButton('<li class=\'fa fa-save\'></li> Submit Invoice' , ['class' =>'form-btn btn btn-dark btn-lg']) ?>
         </div>
    </div>

</div>
<br/>

<?php ActiveForm::end(); ?>  
    

