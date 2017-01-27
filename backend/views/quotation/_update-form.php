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

use common\models\Gst;

$getGst = Gst::find()->where(['branch_id' => $model['branch_id'] ])->one();

if( isset($getGst) ) {
    $grandTotal = $model['grand_total'] / $getGst->gst;

}else{
    $grandTotal = $model['grand_total'];

}

$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'supplier_name');
$dataProduct = ArrayHelper::map(Product::find()->all(), 'id', 'product_name');
$quotationCode = 'QUO' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5);

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
        <span class="form-header"><h4><i class="fa fa-pencil"></i> Update Job-Sheet</h4></span>
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
        <br/><br/>

        <div class="row transactionFormAlign" >

            <div class="col-md-6">
                <div class="row">

                    <div class="col-md-8">

                        <span class="quotationLabel" ><i class="fa fa-barcode"></i> Job-sheet Code </span>

                        <input type="text" name="Quotation[quotationCode]" value="<?= $model['quotation_code'] ?>" class="form_qRInput form-control" id="quotationCode" readonly="readonly" />
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="row">

                <div class="col-md-8">

                    <span class="quotationLabel" style="margin-left: 45px;" ><i class="fa fa-calendar"></i> Date Issue </span>

                    <input type="text" name="Quotation[dateIssue]" style="margin-left: 40px;" id="expiry_date" class="form_qRInput form-control" readonly="readonly" value="<?= $model['date_issue'] ?>" placeholder="CHOOSE DATE HERE" /> 
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

                    <select name="Quotation[selectedBranch]" class="qSelect select3_single" >
                        <option value="<?= $model['branch_id'] ?>">[ <?= $model['code'] ?> ] <?= $model['name'] ?></option>
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
                    
                    <span class="quotationLabel" ><i class="fa fa-users"></i> Customer Name</span>
                    
                    <select name="Quotation[selectedCustomer]" class="qSelect select3_single" >
                        <option value="<?= $model['customer_id'] ?>">[ <?= $model['carplate'] ?> ] <?= $model['fullname'] ?></option>
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
                    
                    <span class="quotationLabel" ><i class="fa fa-user"></i> Sales Person </span>

                    <select name="Quotation[selectedUser]" class="qSelect select3_single" >
                        <option value="<?= $model['user_id'] ?>"><?= $model['salesPerson'] ?></option>
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

            <textarea name="Quotation[remarks]" style="font-size: 11.5px;" placeholder="Write your remarks here." id="message" class="qtxtarea form-control" data-parsley-trigger="keyup" data-parsley-minlength="10" data-parsley-maxlength="300" data-parsley-minlength-message="You need to enter at least a 10 caracters long comment." data-parsley-validation-threshold="10"><?= $model['remarks'] ?></textarea> 
        </div>
        
        </div>
        <br/>

    </div>   
 
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

            <div style="text-align: center;"> <b><span><i class="fa fa-battery-quarter"></i> Services | <i class="fa fa-cogs"></i> Parts </span></b> 
            </div>

            <select class="select2_group form-control" id="services_parts" onchange="quoGetSellingPrice()" >
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

        <div id="quoSelectedContainer"  class="row transactionFormAlign" >
            
            <div class="col-md-12">
                <b><i class="fa fa-thumbs-up"></i> Selected Services or Parts</b>
            </div>
            <hr/>
            
            <?php foreach($getService as $sRow): ?>
            <div class="col-md-12 item-<?= $sRow['id'] ?>">    
                <div class="row item">
                    <div class="col-md-6">
                        <b> <input type="checkbox" name="QuotationDetail[task][]" id="task" class="form_quoSP task"  value="<?= $sRow['serviceId'] ?>" <?php if( $sRow['task'] == 1 ): ?> checked='checked' <?php endif; ?> /> Pending Service ?</b> 
                    </div>

                    <div class="col-md-6">
                        <div style="text-align: right;">
                            <span class="edit-button<?= $sRow['id'] ?> edit-button">
                                <a href="javascript:editSelectedItem(<?= $sRow['id'] ?>)"><i class="fa fa-pencil"></i> Edit</a>
                            </span>
                            <span class="save-button<?= $sRow['id'] ?> save-button hidden">
                                <a href="javascript:saveSelectedItem(<?= $sRow['id'] ?>)"><i class="fa fa-save"></i> Save</a>
                            </span>
                            <span class="remove-button">
                                <a href="javascript:removeSelectedItem(<?= $sRow['id'] ?>)" >&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row item">
                    
                    <div class="col-md-3">
                        <input type="text" class="form_quoSP form-control" id="selected-service" value="<?= $sRow['service_name'] ?>" readonly>
                        <input type="hidden" class="form-control" name="QuotationDetail[service_part_id][]" value="0-<?= $sRow['serviceId'] ?>" readonly>

                    </div>

                    <div class="col-md-3">
                        <input type="text" class="form_quoSP form-control" id="selected-<?= $sRow['id'] ?>-itemQty" name="QuotationDetail[quantity][]" value="<?= $sRow['quantity'] ?>" readonly onchange="updateSelectedItemSubtotal(<?= $sRow['id'] ?>)">
                    </div>

                    <div class="col-md-3">
                        <input type="text" class="form_quoSP form-control" id="selected-<?= $sRow['id'] ?>-itemPrice" name="QuotationDetail[selling_price][]" value="<?= $sRow['selling_price'] ?>" readonly onchange="updateSelectedItemSubtotal(<?= $sRow['id'] ?>)">
                    </div>

                    <div class="col-md-3">
                         <input type="text" class="form_quoSP form-control subTotalGroup" id="selected-<?= $sRow['id'] ?>-subTotal" name="QuotationDetail[subTotal][]" value="<?= $sRow['subTotal'] ?>" readonly>
                    </div>


                </div>
            </div>
            <?php endforeach; ?>

            <?php foreach($getPart as $pRow): ?>
            <div class="col-md-12 item-<?= $pRow['id'] ?>">    
                <div class="row item">
                    <div class="col-md-6"></div>

                    <div class="col-md-6">
                        <div style="text-align: right;">
                            <span class="edit-button<?= $pRow['id'] ?> edit-button">
                                <a href="javascript:editSelectedItem(<?= $pRow['id'] ?>)"><i class="fa fa-pencil"></i> Edit</a>
                            </span>
                            <span class="save-button<?= $pRow['id'] ?> save-button hidden">
                                <a href="javascript:saveSelectedItem(<?= $pRow['id'] ?>)"><i class="fa fa-save"></i> Save</a>
                            </span>
                            <span class="remove-button">
                                <a href="javascript:removeSelectedItem(<?= $pRow['id'] ?>)" >&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row item">
                    
                    <div class="col-md-3">
                        <input type="text" class="form_quoSP form-control" id="selected-<?= $pRow['id'] ?>-service" value="<?= $pRow['product_name'] ?>" readonly>
                        <input type="hidden" class="form-control" name="QuotationDetail[service_part_id][]" value="1-<?= $pRow['productId'] ?>" readonly>

                    </div>

                    <div class="col-md-3">
                        <input type="text" class="form_quoSP form-control" id="selected-<?= $pRow['id'] ?>-itemQty" name="QuotationDetail[quantity][]" value="<?= $pRow['quantity'] ?>" readonly onchange="updateSelectedItemSubtotal(<?= $pRow['id'] ?>)">
                    </div>

                    <div class="col-md-3">
                        <input type="text" class="form_quoSP form-control" id="selected-<?= $pRow['id'] ?>-itemPrice" name="QuotationDetail[selling_price][]" value="<?= $pRow['selling_price'] ?>" readonly onchange="updateSelectedItemSubtotal(<?= $pRow['id'] ?>)">
                    </div>

                    <div class="col-md-3">
                         <input type="text" class="form_quoSP form-control subTotalGroup" id="selected-<?= $pRow['id'] ?>-subTotal" name="QuotationDetail[subTotal][]" value="<?= $pRow['subTotal'] ?>" readonly>
                    </div>


                </div>
            </div>
            <?php endforeach; ?>

            <div class="col-md-12">
                <div class="selected-item-list" id="selected-item-list"></div><br/>
            </div>

        </div>
        <br/>

        <div  class="row transactionFormAlign" >

            <div class="col-md-4"></div>

            <div class="col-md-3"></div>

            <div class="col-md-3"></div>

            <div class="col-md-2">
                <input type="text" name="Quotation[grand_total]" class="grandTotal form_quoSP form-control" id="grandTotal" style="text-align: center;" value="<?= $grandTotal ?>" placeholder="Total Price" readonly />
            </div>
        
        </div>

        <input type="hidden" id='n' value="<?= $getLastId ?>">
        <br/>

    </div>   
 
 </div>

</div>
<br/>

<div class="row">

    <div class="col-md-12">
        <div style="text-align: right;">        
        <?= Html::submitButton('<li class=\'fa fa-save\'></li> Update Job-Sheet' , ['class' =>'form-btn btn btn-dark btn-lg']) ?>
         </div>
    </div>

</div>
<br/>

<?php ActiveForm::end(); ?>



