<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Branch;
use common\models\CarInformation;
use common\models\User;

use common\models\Supplier;
use common\models\ServiceCategory;
use common\models\Category;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$datetime = date('Y-m-d h:i:s');
$dateNow = date('d-m-Y');

$userId = Yii::$app->user->identity->id;
$dataServiceCategory = ServiceCategory::find()->where(['status' => 1])->all();
$dataSupplier = Supplier::find()->where(['status' => 1])->all();
$dataCategory = Category::find()->where(['status' => 1])->all();

$yrNow = date('Y');
$monthNow = date('m');
$invoiceCode = 'INV' . $yrNow  . $monthNow . sprintf('%003d', $invoiceId);
$invoiceCodeValue = $invoiceCode;

$dataBranch = ArrayHelper::map(Branch::find()->where('id > 1')->andWhere(['status' => 1])->all(),'id', 'name');
$dataCustomer = ArrayHelper::map(CarInformation::find()->where('status = 1')->all(),'id', 'carplate');
$dataUser = ArrayHelper::map(User::find()->where(['status' => 1])->all(),'id', 'fullname');

?>

<?php $form = ActiveForm::begin(['id' => 'arh-form']); ?>

<div class="row transactionform-container">

<div>
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
            <h5 class="alert-heading"><i class="fa fa-info-circle"></i> <?= Yii::$app->session->getFlash('success'); ?></h5>
        </div>
    <?php endif; ?>
</div>

<div class="form-crud-container">

<div class="col-md-12 col-sm-12 col-xs-12">
 
<div class="form-title-container">
    <span class="form-header"><h4><i class="fa fa-pencil-square-o"></i> Create Invoice</h4></span>
</div>
<hr/>

<?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>
<br/><br/>

</div>

<div class="col-md-12 col-sm-12 col-xs-12 quotationHeader">       
    <div>
        <span class="quotationHeaderLabel" > <li class="fa fa-info"></li> Customer Information </span>
    </div>
</div>
<br/><br/>

<div class="col-md-5 col-sm-5 col-xs-5">
<br/>

    <div class="row transactionFormAlign" >
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <span class="quotationLabel" ><i class="fa fa-barcode"></i> Invoice Number </span>

                    <?= $form->field($model, 'invoice_no')->textInput(['class' => 'form_qRInput form-control', 'id' => 'invoiceCode', 'value' => $invoiceCodeValue, 'readonly' => 'readonly'])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="row transactionFormAlign" >
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <span class="quotationLabel" > <i class="fa fa-globe"></i> Branch </span>

                    <?= $form->field($model, 'branch_id')->dropdownList(['0' => '- PLEASE SELECT BRANCH -'] + $dataBranch,['class' => 'qSelect select3_single getBranchGstForInvoice', 'id' => 'invBranch', 'data-placeholder' => 'CHOOSE BRANCH HERE'])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="row transactionFormAlign" >
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <span class="quotationLabel" > <i class="fa fa-user"></i> Sales Person </span>

                    <?= $form->field($model, 'user_id')->dropdownList(['0' => '- PLEASE SELECT SALES PERSON -'] + $dataUser,['class' => 'qSelect select3_single', 'value' => $userId, 'data-placeholder' => 'CHOOSE SALES PERSON HERE', 'id' => 'salesPerson' ])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="row transactionFormAlign" >
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8">
                    <span class="quotationLabel" > <i class="fa fa-dashboard"></i> Mileage </span>

                    <?= $form->field($model, 'mileage')->textInput(['class' => 'form_qRInput form-control', 'placeholder' => 'ENTER MILEAGE HERE', 'id' => 'mileage' ])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="row transactionFormAlign" >
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <span class="quotationLabel" ><i class="fa fa-comment"></i> Remarks </span>
            
                    <?= $form->field($model, 'remarks')->textarea(['style' => 'font-size:11px;', 'id' => 'invMessage', 'class' => 'qtxtarea form-control', 'data-parsley-trigger' => 'keyup', 'data-parsley-minlength' => '10', 'data-parsley-maxlength' => '300', 'data-parsley-minlength-message' => 'You need to enter at least a 10 characters long comment.', 'data-parsley-validation-threshold' => '10', 'placeholder' => 'WRITE REMARKS HERE.'])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <br/>

</div>
 
<div class="col-md-7 col-sm-7 col-xs-7">
<br/>

    <div class="row transactionFormAlign" >
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-7">
                    <span class="quotationLabel" > <i class="fa fa-calendar"></i> Date Issue </span>

                    <?= $form->field($model, 'date_issue')->textInput(['class' => 'form_qRInput form-control dateIssue', 'id' => 'expiry_date', 'value' => $dateNow, 'readonly' => 'readonly', 'placeholder' => 'CHOOSE DATE HERE'])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="row transactionFormAlign" >
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <span class="quotationLabel" > <i class="fa fa-calendar-plus-o"></i> Date Come-In </span>

                    <?= $form->field($model, 'come_in')->textInput(['class' => 'form_qRInput form-control', 'id' => 'datetimepicker_comein', 'placeholder' => 'CHOOSE DATE HERE'])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <span class="quotationLabel" > <i class="fa fa-calendar-minus-o"></i> Date Come-Out </span>

                    <?= $form->field($model, 'come_out')->textInput(['class' => 'form_qRInput form-control', 'id' => 'datetimepicker_comeout', 'placeholder' => 'CHOOSE DATE HERE'])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="row transactionFormAlign" >
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-7">
                    <span class="quotationLabel" > <i class="fa fa-users"></i> Customer Name</span>
                    
                    <?= $form->field($model, 'customer_id')->dropdownList(['0' => '- PLEASE SELECT CUSTOMER -'] + $dataCustomer,['class' => 'qSelect select3_single getInvCustomerInfo', 'id' => 'getInvCustomerInfo', 'data-placeholder' => 'CHOOSE CUSTOMER HERE'])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="row transactionFormAlign" >
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="customer-invoice-information" class="customer-invoice-information" ></div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

</div>

<div class="row transactionform-container">

 <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="form-crud-container">
        
        <div class="row quotationHeader">
            <div class="col-md-12 col-sm-12 col-xs-12">
                
                <div>
                    <span class="quotationHeaderLabel" > <li class="fa fa-chain-broken"></li> Services or Products Information </span>
                </div>
            
            </div>
        </div>
        <br/>

        <div class="row transactionFormAlign" >
            <div class="col-md-12 col-sm-12 col-xs-12 quotationHeader">
                <div>
                    <span class="quotationHeaderLabel" > <li class="fa fa-chain"></li> Product Section </span>
                </div>
            </div>
            <br/><br/>

            <div class="col-md-3">
                <div class="quoSPLabel"> <b><span><i class="fa fa-codiepie"></i> Products Category </span></b> 
                </div>

                <select class="select2_multiple form-control" id="partsCategory" onchange="invGetPartsList()" data-placeholder="CHOOSE PARTS CATEGORY HERE" >
                        <option value="0">- PLEASE SELECT PARTS CATEGORY -</option>
                    <?php foreach($dataCategory as $rowCategory): ?>
                        <option value="<?php echo $rowCategory['id']; ?>"><?php echo $rowCategory['category']; ?></option>
                    <?php endforeach; ?>    
                </select>
            </div>

            <div class="col-md-9">
                <div class="quoSPLabel"> <b><span>- <i class="fa fa-pinterest-p"></i>roduct List -</span></b> 
                </div>

                <select class="select2_multiple form-control" multiple="multiple" id="services_parts" onchange="invSelectParts()" data-placeholder="CHOOSE PRODUCTS HERE" >
                        <?php if( !empty($getPartsList) ): ?>
                            <?php foreach($getPartsList as $prowList): ?>
                                <option value="<?php echo $prowList['id']; ?>">[ <?php echo $prowList['supplier_name']; ?> ] <?php echo $prowList['product_name']; ?></option>                 
                            <?php endforeach; ?>
                            <!-- <option value="otherParts">Other Product.</option> -->
                        <?php else: ?>
                            <option value="0">NO RECORD FOUND.</option>
                        <?php endif; ?>
                </select>
            </div>   
        </div>
        <br/>

        <div class="row transactionFormAlign" >
            <input type="hidden" id="partsCtr" value="0" />
            <div class="parts-item-list" id="parts-item-list"></div>
        </div>
        <hr/>

        <div class="row transactionFormAlign" >
            
        <div class="col-md-12 quotationHeader">
            <div>
                <span class="quotationHeaderLabel" > <li class="fa fa-cab"></li> Service/Labour Section </span>
            </div>
        </div>
        <br/><br/>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <label><i class="fa fa-money"></i>Service Price</label>
                <input type="text" class="form_qRInput form-control" placeholder="Enter Service Price here." name="serviceInvPrice" id="serviceInvPrice" readonly="readonly" />
                    </div>

                    <div class="col-md-8">
                        <label><i class="fa fa-commenting-o"></i> Service Description</label>
                        <textarea id="serviceInvDescription" rows="1" style="font-size:11px;" name="serviceInvDescription" class="qtxtarea form-control" placeholder="WRITE SERVICE DESCRIPTION HERE." readonly="readonly" ></textarea>

                        <div style="margin-top: 10px;">
                            <button type="button" class="otherInvServices form-btn btn btn-info pull-right" id="otherInvServices" ><i class="fa fa-user-o"></i> Add Services - </button>
                            <button type="button" class="submitInvServices form-btn btn btn-primary pull-right hidden" id="submitAddedInvService"><i class="fa fa-save"></i> Save Services- </button>
                            <button type="button" id="cancelAddedInvService" class="clearInvServices form-btn btn btn-danger pull-right hidden" id="clearInvServices"><i class="fa fa-refresh"></i> Cancel - </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div style="margin-top: 10px;" class="row transactionFormAlign" >
        <input type="hidden" id="serviceCtr" value="0" />

            <div class="service-item-list" id="service-item-list"></div>

        </div> -->

        <div class="row transactionFormAlign" >
        <br/>
            <div class="col-md-12 quotationHeader">
                <div>
                    <span class="quotationHeaderLabel" ><i class="fa fa-battery-1"></i> Discount </span>
                </div>
            </div>
            <br/><br/>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <span class="selectedLabel"><i class="fa fa-minus-circle"></i> Discount Amount </span>
                        <input type="text" name="Invoice[discount_amount]" class="form_qRInput form-control" id="discountInvAmount" placeholder="Discount Price" readonly="readonly" />
                    </div>

                    <div class="col-md-8">
                        <span class="selectedLabel"><i class="fa fa-commenting"></i> Discount Remarks</span>
                        <textarea id="discountInvRemarks" rows="1" style="font-size:11px;" name="Invoice[discount_remarks]" class="qtxtarea form-control" placeholder="WRITE SERVICE DESCRIPTION HERE." readonly="readonly" ></textarea>

                        <div style="margin-top: 10px;">
                            <button type="button" class="btnInvDiscount form-btn btn btn-info pull-right" id="btnInvDiscount" ><i class="fa fa-battery-0"></i> Add Discount - </button>
                            <button type="button" class="submitInvDiscount form-btn btn btn-primary pull-right hidden" id="submitInvDiscount"><i class="fa fa-save"></i> Save Discount - </button>
                            <button type="button" class="clearInvDiscount form-btn btn btn-danger pull-right hidden" id="clearInvDiscount"><i class="fa fa-refresh"></i> Cancel - </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/><hr/>

        <div id="quoSelectedContainer" class="row transactionFormAlign" >
            
            <div class="col-md-12 selectedContainerHeader">
                <b><i class="fa fa-shopping-cart"></i> Selected Services or Parts</b>
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
                <span class="selectedLabel"><center>Sub-Total</center></span>
                <input type="text" name="Invoice[grand_total]" class="grandTotal form-control" id="grandTotal" placeholder="Total Price" readonly />
                <br/>

                <span class="selectedLabel"><center>GST(7%)</center></span>
                <input type="hidden" name="gst" class="grandTotal form-control" id="gst" placeholder="GST Amount" readonly />
                <input type="text" name="Invoice[gst]" class="grandTotal form-control" id="gstResult" placeholder="GST Amount" readonly />
                <br/>

                <span class="selectedLabel"><center>Nett Total</center></span>
                <input type="text" name="Invoice[net]" class="grandTotal form-control" id="netTotal" placeholder="Total Price" readonly />
            </div>
        
        </div>

        <input type="hidden" id='n' value="0">
        <br/>

    </div>   
 
 </div>

<?php ActiveForm::end(); ?>  

<div class="col-md-12">
<hr/>
    <div style="text-align: right;">        
        <?= Html::Button('<li class=\'fa fa-save\'></li> Submit Invoice' , ['class' =>'form-btn btn btn-dark btn-lg', 'id' => 'submitInvoiceForm' ]) ?>
    </div>
<br/>
</div>

</div>
    
<!-- <div class="modal fade" id="modal-launcher-service" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-cab"></i> <b>Other Service</b> </h5>
            </div>

        <div class="modal-body">

            <form id="s-modal-form" class="s-modal-form" method="POST">

                <label>Service Description</label>
                <textarea id="serviceDescription" style="font-size:11px;" name="serviceDescription" class="qtxtarea form-control" placeholder="Write Service Description Here."></textarea>
                <br/>

                <label>Price</label>
                <input type="text" class="form_qRInput form-control" placeholder="Enter Service Price here." name="servicePrice" id="servicePrice" />

            </form>

        </div>

        <div class="modal-footer">
            <button type="button" id="modal-submit-s" class="form-btn btn btn-primary"><i class="fa fa-save"></i> Submit</button>
        </div>

        </div>
    </div>
</div>
​
<div class="modal fade" id="modal-launcher-part" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"><i class="fa fa-chain"></i> <b>Other Product</b> </h5>
            </div>

        <div class="modal-body">

            <form id="p-modal-form" class="p-modal-form" method="POST">

                <label>Product Description</label>
                <textarea id="partsDescription" style="font-size:11px;" name="partsDescription" class="qtxtarea form-control" placeholder="Write Product Description Here."></textarea>
                <br/>

                <label>Price</label>
                <input type="text" class="form_qRInput form-control" placeholder="Enter Product Price here." name="partsPrice" id="partsPrice" />

            </form>

        </div>

        <div class="modal-footer">
            <button type="button" id="modal-submit-p" class="form-btn btn btn-primary"><i class="fa fa-save"></i> Submit</button>
        </div>

        </div>
    </div>
</div> -->