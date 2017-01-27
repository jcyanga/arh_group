<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Branch;
use common\models\Supplier;
use common\models\Product;
use common\models\Customer;
use common\models\ServiceCategory;
use common\models\Category;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;
$dataServiceCategory = ServiceCategory::find()->all();
$dataSupplier = Supplier::find()->all();
$dataCategory = Category::find()->all();
$quotationCode = 'JS' . '/' . $quotationId . '/' .  substr(uniqid('', true), -5);
$quotationCodeValue = $quotationCode;

$getCustomerInfo = Customer::find()->where(['id' => $customer_id])->one();
$userId = $getCustomerInfo['id'];
$fullName = $getCustomerInfo['fullname'];
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
        <span class="form-header"><h4><i class="fa fa-pencil"></i> Create Job-Sheet</h4></span>
    </div>
    <hr/>

    <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
    <br/><br/>

    <div class="form-crud-container">
        
        <div class="row quotationHeader">
            <div class="col-md-12">
                
                <div >
                    <span class="quotationHeaderLabel" > <li class="fa fa-info"></li> Customer Information </span>
                </div>
            
            </div>
        </div>
        <br/>

        <div class="row transactionFormAlign" >
            <div class="col-md-12">
                <h4 style="text-transform: uppercase; color: #2A3F54;"><i class="fa fa-users"></i> Customer Name: <?= Html::encode($fullName) ?></h4>
            </div>    
        </div>
        <br/>

        <div class="row transactionFormAlign" >

            <div class="col-md-6">
                <div class="row">

                    <div class="col-md-8">

                        <span class="quotationLabel" ><i class="fa fa-barcode"></i> Job-sheet Code </span>

                        <input type="text" name="Quotation[quotationCode]" value="<?php echo $quotationCodeValue; ?>" class="form_qRInput form-control" id="quotationCode" readonly="readonly" />
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="row">

                <div class="col-md-8">

                    <span class="quotationLabel" ><i class="fa fa-calendar"></i> Date Issue </span>

                    <input type="text" name="Quotation[dateIssue]" id="expiry_date" class="form_qRInput form-control" readonly="readonly" placeholder="CHOOSE DATE HERE" />    
                </div>

                </div>
            </div>
            
        </div>
        <br/><br/>

        <div class="row transactionFormAlign" >

        <div class="col-md-6">
            <div class="row">

                <div class="col-md-8">
                    
                    <span class="quotationLabel" ><i class="fa fa-globe"></i> Branch </span>

                    <select name="Quotation[selectedBranch]" class="qSelect select3_single">
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
                    
                    <span class="quotationLabel" ><i class="fa fa-user"></i> Sales Person </span>

                    <select name="Quotation[selectedUser]" class="qSelect select3_single" >
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
            
            <span class="quotationLabel" ><i class="fa fa-comment"></i> Remarks </span>
            <textarea name="Quotation[remarks]" style="font-size: 11.5px;" placeholder="Write your remarks here." id="message" class="qtxtarea form-control" data-parsley-trigger="keyup" data-parsley-minlength="10" data-parsley-maxlength="300" data-parsley-minlength-message="You need to enter at least a 10 caracters long comment." data-parsley-validation-threshold="10"></textarea> 
        </div>
        
        </div>
        <br/>

    </div>   
    <br/>
    
 </div>

</div>

<div class="row transactionform-container">

 <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-crud-container">
        
        <div class="row quotationHeader">
            <div class="col-md-12">
                
                <div>
                    <span class="quotationHeaderLabel" > <li class="fa fa-chain-broken"></li> Services or Parts Information </span>
                </div>
            
            </div>
        </div>
        <br/><br/>

        <div class="row transactionFormAlign" >

        <div class="col-md-5">

            <div class="quoSPLabel"> <b><span><i class="fa fa-list"></i> Services & Parts </span></b> 
            </div>

            <select class="select2_group form-control" id="services_parts" onchange="quoGetSellingPrice()" >
                <option value="0">SEARCH PARTS OR SERVICES</option>
                
                <optgroup label="- SERVICES - ">
                    <?php if( !empty($getServicesList) ): ?>
                        <?php foreach($getServicesList as $srowList): ?>
                            <option value="0-<?php echo $srowList['id']; ?>">[ <?php echo $srowList['name']; ?> ] <?php echo $srowList['service_name']; ?></option>                 
                        <?php endforeach; ?>
                        <option value="otherServices">Other Services.</option>
                    <?php else: ?>
                        <option value="0">NO RECORD FOUND.</option>
                    <?php endif; ?>
                 </optgroup>

                 <optgroup label="- PARTS - ">
                    <?php if( !empty($getPartsList) ): ?>
                        <?php foreach($getPartsList as $prowList): ?>
                            <option value="1-<?php echo $prowList['id']; ?>">[ <?php echo $prowList['supplier_name']; ?> | <?php echo $prowList['category']; ?> ] <?php echo $prowList['product_name']; ?></option>                 
                        <?php endforeach; ?>
                        <option value="otherParts">Other Parts.</option>
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
        
                <div class="quoSPLabel"> <b><span><i class="fa fa-database"></i> Quantity </span></b> </div>
    
                <input type="text"  id="itemQty" onchange="quoUpdateSubTotal()" class="quantity form_quoSP form-control" placeholder="Qty" />

            </div>

            <div class="col-md-3">
        
                <div class="quoSPLabel"> <b><span><i class="fa fa-usd"></i> Selling Price </span></b> </div>
           
                <input type="text" id="itemPriceValue" onchange="quoUpdateSubTotal()" class="unit_price form_quoSP form-control" placeholder="0.00" />

            </div>

            <div class="col-md-3">
        
                <div class="quoSPLabel"> <b><span><i class="fa fa-money"></i> Sub-Total </span></b> </div>
                
                <input type="text" id="itemSubTotal" class="sub_total form_quoSP form-control" readonly="readonly" placeholder="0.00" />

            </div>

            <div class="col-md-3">
        
                <div class="quoSPLabel"> <b><span><i class="fa fa-bars"></i> Action </span></b> </div>
               
                <div class="quoSPAction">
                    <a href="javascript:quoAddItemList()" id="quoAddItemList" class="form-btn btn btn-link" ><i class='fa fa-plus-circle'></i> Add Item in List </a>
                </div>

            </div>

        </div>
        <br/>

        <div id="quoSelectedContainer" class="row transactionFormAlign" >
            
            <div class="col-md-12 selectedContainerHeader">
                <b><i class="fa fa-thumbs-up"></i> Selected Services or Parts</b>
            </div>
            <hr/>
            
            <div class="col-md-12">
                <div class="selected-item-list" id="selected-item-list"></div><br/>
            </div>
        </div>
        <br/>

        <div style="margin: 0 auto;" class="row">

            <div class="col-md-4"></div>

            <div class="col-md-3"></div>

            <div class="col-md-3"></div>

            <div class="col-md-2">
                <input type="text" name="Quotation[grand_total]" class="grandTotal form_quoSP form-control" id="grandTotal" style="text-align: center;" placeholder="Total Price" readonly />
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
        <?= Html::submitButton('<li class=\'fa fa-save\'></li> Submit Job-Sheet' , ['class' =>'form-btn btn btn-dark btn-lg']) ?>
         </div>
    </div>

</div>
<br/>

<?php ActiveForm::end(); ?>

<div class="modal fade" id="modal-launcher-service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-battery-quarter"></i> New Service</h4>
            </div>

        <div class="modal-body">

            <form id="sc-modal-form" class="sc-modal-form" method="POST">

                <label>Service Category</label>
                <select class="mform_input form-control select3_single" style="width: 100%;" name="service_category" id="service_category">
                    <?php foreach($dataServiceCategory as $scRow): ?>
                        <option value="<?php echo $scRow['id']; ?>"><?php echo $scRow['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br/><br/>

                <label>Service Name</label>
                <input type="text" class="mform_input form-control" placeholder="Enter Service Name here." name="service" id="service" />
                <br/>

                <label>Price</label>
                <input type="text" class="mform_input form-control" placeholder="Enter Service Price here." name="default_price" id="default_price" />

            </form>

        </div>

        <div class="modal-footer">
            <button type="button" id="modal-submit-s" class="form-btn btn btn-primary">Submit</button>
        </div>

        </div>
    </div>
</div>
​
<div class="modal fade" id="modal-launcher-part" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> New Parts</h4>
            </div>

        <div class="modal-body">

            <form id="p-modal-form" class="p-modal-form" method="POST">

                <label>Parts Supplier</label>
                <select class="mform_input form-control select3_single" style="width: 100%;" name="parts_supplier" id="parts_supplier">
                    <?php foreach($dataSupplier as $sRow): ?>
                        <option value="<?php echo $sRow['id']; ?>"><?php echo $sRow['supplier_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br/><br/>

                <label>Parts Category</label>
                <select class="mform_input form-control select3_single" style="width: 100%;" name="parts_category" id="parts_category">
                    <?php foreach($dataCategory as $cRow): ?>
                        <option value="<?php echo $cRow['id']; ?>"><?php echo $cRow['category']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br/><br/>

                <label>Parts Name</label>
                <input type="text" class="mform_input form-control" placeholder="Enter Parts Name here." name="parts" id="parts" />
                <br/>

                <label>Unit of Measure</label>
                <input type="text" class="mform_input form-control" placeholder="Enter Parts Unit of Measure here." name="parts_uom" id="parts_uom" />
                <br/>

                <label>Price</label>
                <input type="text" class="mform_input form-control" placeholder="Enter Parts Price here." name="selling_price" id="selling_price" />

            </form>

        </div>

        <div class="modal-footer">
            <button type="button" id="modal-submit-p" class="form-btn btn btn-primary">Submit</button>
        </div>

        </div>
    </div>
</div>








    

