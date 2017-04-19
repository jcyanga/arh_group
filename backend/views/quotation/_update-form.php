<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Branch;
use common\models\Customer;
use common\models\User;

use common\models\Supplier;
use common\models\ServiceCategory;
use common\models\Category;
use common\models\CarInformation;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$dataBranch = ArrayHelper::map(Branch::find()->where('id > 1')->all(),'id', 'name');
$dataCustomer = ArrayHelper::map(CarInformation::find()->where('status = 1')->all(),'id', 'carplate');
$dataUser = ArrayHelper::map(User::find()->all(),'id', 'fullname');

$dataServiceCategory = ServiceCategory::find()->where(['status' => 1])->all();
$dataSupplier = Supplier::find()->where(['status' => 1])->all();
$dataCategory = Category::find()->where(['status' => 1])->all();

$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;

if(!is_null(Yii::$app->request->get('id')) || Yii::$app->request->get('id') <> ''){
    $id = Yii::$app->request->get('id'); 
}else{
    $id = 0;
}

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
    <span class="form-header"><h4><i class="fa fa-pencil-square-o"></i> Edit Job-Sheet</h4></span>
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
                    <span class="quotationLabel" ><i class="fa fa-barcode"></i> Job-sheet Code </span>
                    <input type="hidden" name="id" id="id" value="<?= $id ?>" />
                    <?= $form->field($model, 'quotation_code')->textInput(['class' => 'form_qRInput form-control', 'id' => 'quotationCode', 'value' => $quotation['quotation_code'], 'readonly' => 'readonly'])->label(false) ?>
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

                    <?= $form->field($model, 'branch_id')->dropdownList(['0' => '- PLEASE SELECT BRANCH -'] + $dataBranch,['class' => 'qSelect select3_single getBranchGst', 'id' => 'quoBranch', 'value' => $quotation['branch_id'], 'data-placeholder' => 'CHOOSE BRANCH HERE'])->label(false) ?>
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

                    <?= $form->field($model, 'user_id')->dropdownList(['0' => '- PLEASE SELECT SALES PERSON -'] + $dataUser,['class' => 'qSelect select3_single', 'value' => $quotation['user_id'], 'data-placeholder' => 'CHOOSE SALES PERSON HERE', 'id' => 'salesPerson' ])->label(false) ?>
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

                    <?= $form->field($model, 'mileage')->textInput(['class' => 'form_qRInput form-control', 'value' => $quotation['mileage'], 'placeholder' => 'ENTER MILEAGE HERE', 'id' => 'mileage' ])->label(false) ?>
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
            
                    <?= $form->field($model, 'remarks')->textarea(['style' => 'font-size:11px;', 'id' => 'message', 'class' => 'qtxtarea form-control', 'data-parsley-trigger' => 'keyup', 'data-parsley-minlength' => '10', 'data-parsley-maxlength' => '300', 'data-parsley-minlength-message' => 'You need to enter at least a 10 characters long comment.', 'data-parsley-validation-threshold' => '10', 'value' => $quotation['remarks'], 'placeholder' => 'WRITE REMARKS HERE.'])->label(false) ?>
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

                    <?= $form->field($model, 'date_issue')->textInput(['class' => 'form_qRInput form-control dateIssue', 'id' => 'expiry_date', 'readonly' => 'readonly', 'value' => date('d-m-Y', strtotime($quotation['date_issue'])), 'placeholder' => 'CHOOSE DATE HERE'])->label(false) ?>
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

                    <?= $form->field($model, 'come_in')->textInput(['class' => 'form_qRInput form-control', 'id' => 'update_datetimepicker_comein', 'value' =>  date('d-m-Y H:i:s', strtotime($quotation['come_in'])), 'placeholder' => '--/--/---- --:--:--'])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <span class="quotationLabel" > <i class="fa fa-calendar-minus-o"></i> Date Come-Out </span>

                    <?= $form->field($model, 'come_out')->textInput(['class' => 'form_qRInput form-control', 'id' => 'update_datetimepicker_comeout', 'value' => date('d-m-Y H:i:s', strtotime($quotation['come_out'])), 'placeholder' => '--/--/---- --:--:--'])->label(false) ?>
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
                    
                    <?= $form->field($model, 'customer_id')->dropdownList(['0' => '- PLEASE SELECT CUSTOMER -'] + $dataCustomer,['class' => 'qSelect select3_single getUpdateCustomerInfo', 'id' => 'getUpdateCustomerInfo', 'value' => $quotation['customer_id'], 'data-placeholder' => 'CHOOSE CUSTOMER HERE'])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <br/>

    <div class="row transactionFormAlign" >
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="customer-information" class="customer-information" ></div>
                    <?php if($quotation['type'] == 1): ?>
                        <table style="width: 100%;">
                            <tr>
                                <td>
                                    <table class="table table-hover table-striped viewTableContent companyInformation">
                                        <tr>
                                            <td><b>COMPANY NAME</b></td>
                                            <td><?= strtoupper($quotation['company_name']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>UEN NUMBER</b></td>
                                            <td><?= strtoupper($quotation['uen_no']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>CONTACT PERSON</b></td>
                                            <td><?= strtoupper($quotation['fullname']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>ADDRESS</b></td>
                                            <td><?= strtoupper($quotation['address']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>PHONE NUMBER</b></td>
                                            <td><?= $quotation['hanphone_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>OFFICE NUMBER</b></td>
                                            <td><?= $quotation['office_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>EMAIL</b></td>
                                            <td><?= strtoupper($quotation['email']); ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table class="table table-hover table-striped viewTableContent" id="carInformation">
                                        <tr>
                                            <td><b>VEHICLE NUMBER</b></td>
                                            <td><?= strtoupper($quotation['carplate']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>CAR MAKE</b></td>
                                            <td><?= strtoupper($quotation['make']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>CAR MODEL</b></td>
                                            <td><?= strtoupper($quotation['model']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>ENGINE NUMBER</b></td>
                                            <td><?= $quotation['engine_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>YEAR MFG</b></td>
                                            <td><?= $quotation['year_mfg']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>CHASIS</b></td>
                                            <td><?= strtoupper($quotation['chasis']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>REWARD POINTS</b></td>
                                            <td><?= $quotation['points']; ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    <?php else: ?>
                        <table style="width: 100%;">
                            <tr>
                                <td>
                                    <table class="table table-hover table-striped viewTableContent companyInformation">
                                        <tr>
                                            <td><b>CUSTOMER NAME</b></td>
                                            <td><?= strtoupper($quotation['fullname']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>NRIC NUMBER</b></td>
                                            <td><?= strtoupper($quotation['nric']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>RACE</b></td>
                                            <td><?= strtoupper($quotation['name']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>ADDRESS</b></td>
                                            <td><?= strtoupper($quotation['address']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>PHONE NUMBER</b></td>
                                            <td><?= $quotation['hanphone_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>OFFICE NUMBER</b></td>
                                            <td><?= $quotation['office_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>EMAIL</b></td>
                                            <td><?= strtoupper($quotation['email']); ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table class="table table-hover table-striped viewTableContent" id="carInformation">
                                        <tr>
                                            <td><b>VEHICLE NUMBER</b></td>
                                            <td><?= strtoupper($quotation['carplate']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>CAR MAKE</b></td>
                                            <td><?= strtoupper($quotation['make']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>CAR MODEL</b></td>
                                            <td><?= strtoupper($quotation['model']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>ENGINE NUMBER</b></td>
                                            <td><?= $quotation['engine_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>YEAR MFG</b></td>
                                            <td><?= $quotation['year_mfg']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>CHASIS</b></td>
                                            <td><?= strtoupper($quotation['chasis']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>REWARD POINTS</b></td>
                                            <td><?= $quotation['points']; ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    <?php endif; ?>
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

                <select class="select2_multiple form-control" id="partsCategory" onchange="quoGetPartsList()" data-placeholder="CHOOSE PARTS CATEGORY HERE" >
                        <option value="0">- PLEASE SELECT PARTS CATEGORY -</option>
                    <?php foreach($dataCategory as $rowCategory): ?>
                        <option value="<?php echo $rowCategory['id']; ?>"><?php echo $rowCategory['category']; ?></option>
                    <?php endforeach; ?>    
                </select>
            </div>

            <div class="col-md-9">
                <div class="quoSPLabel"> <b><span>- <i class="fa fa-pinterest-p"></i>roduct List -</span></b> 
                </div>

                <select class="select2_multiple form-control" multiple="multiple" id="services_parts" onchange="quoSelectParts()" data-placeholder="CHOOSE PRODUCTS HERE" >
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
                <input type="text" class="form_qRInput form-control" placeholder="Enter Service Price here." name="servicePrice" id="servicePrice" readonly="readonly" />
                    </div>

                    <div class="col-md-8">
                        <label><i class="fa fa-commenting-o"></i> Service Description</label>
                        <textarea id="serviceDescription" rows="1" style="font-size:11px;" name="serviceDescription" class="qtxtarea form-control" placeholder="WRITE SERVICE DESCRIPTION HERE." readonly="readonly" ></textarea>

                        <div style="margin-top: 10px;">
                            <button type="button" class="otherServices form-btn btn btn-info pull-right" id="otherServices" ><i class="fa fa-user-o"></i> Add Services - </button>
                            <button type="button" class="submitServices form-btn btn btn-primary pull-right hidden" id="submitAddedService"><i class="fa fa-save"></i> Save Services- </button>
                            <button type="button" id="cancelAddedService" class="clearServices form-btn btn btn-danger pull-right hidden" id="clearServices"><i class="fa fa-refresh"></i> Cancel - </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>

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
                        <input type="text" name="Quotation[discount_amount]" class="form_qRInput form-control" id="discountAmount" placeholder="Discount Price" value="<?= ($quotation['discount_amount'] <> '0.00')? number_format($quotation['discount_amount']) : ''; ?>" readonly="readonly" />
                        <input type="hidden" id="discountAmountCopy" class="discountAmountCopy" value="<?= $quotation['discount_amount'] ?>" />
                    </div>

                    <div class="col-md-8">
                        <span class="selectedLabel"><i class="fa fa-commenting"></i> Discount Remarks</span>
                        <textarea id="discountUpdateRemarks" rows="1" style="font-size:11px;" name="Quotation[discount_remarks]" class="qtxtarea form-control" placeholder="WRITE SERVICE DESCRIPTION HERE." readonly="readonly" ><?= ($quotation['discount_remarks'] <> 'No discount remarks.')? strtoupper($quotation['discount_remarks']) : ''; ?></textarea>

                        <div style="margin-top: 10px;">
                            <button type="button" class="btnUpdateDiscount form-btn btn btn-info pull-right" id="btnUpdateDiscount" ><i class="fa fa-battery-0"></i> Add Discount - </button>
                            <button type="button" class="submitUpdateDiscount form-btn btn btn-primary pull-right hidden" id="submitUpdateDiscount"><i class="fa fa-save"></i> Save Discount - </button>
                            <button type="button" class="clearUpdateDiscount form-btn btn btn-danger pull-right hidden" id="clearUpdateDiscount"><i class="fa fa-refresh"></i> Cancel - </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/><hr/>

        <div id="quoSelectedContainer"  class="row transactionFormAlign" >
            
            <div class="col-md-12 selectedContainerHeader">
                <b><i class="fa fa-shopping-cart"></i> Selected Services or Parts</b>
            </div>
            <hr/>
            
            <?php foreach($getService as $sRow): ?>
            <div class="col-md-12 item-<?= $sRow['id'] ?>">    
                <div class="row item">
                    
                    <div class="col-md-3">
                        <span class="selectedLabel"><center><?= strtoupper($sRow['service_part_id']) ?></center></span>
                        <input type="hidden" class="form_quoSP form-control" id="selected-service" value="<?= strtoupper($sRow['service_part_id']) ?>" readonly>
                        <input type="hidden" class="servicePartId form-control" name="QuotationDetail[service_part_id][]" value="0-<?= $sRow['service_part_id'] ?>" readonly>

                    </div>

                    <div class="col-md-2">
                        <span class="selectedLabel"><center><?= $sRow['quantity'] ?></center></span>
                        <input type="hidden" class="itemQty form_quoSP form-control" id="selected-<?= $sRow['id'] ?>-itemQty" name="QuotationDetail[quantity][]" value="<?= $sRow['quantity'] ?>" readonly onchange="updateSelectedItemSubtotal(<?= $sRow['id'] ?>)">
                    </div>

                    <div class="col-md-2">
                        <span class="selectedLabel"><center><?= number_format($sRow['selling_price'],2) ?></center></span>
                        <input type="hidden" class="itemPriceValue form_quoSP form-control" id="selected-<?= $sRow['id'] ?>-itemPrice" name="QuotationDetail[selling_price][]" value="<?= $sRow['selling_price'] ?>" readonly onchange="updateSelectedItemSubtotal(<?= $sRow['id'] ?>)">
                    </div>

                    <div class="col-md-2">
                         <span class="selectedLabel"><center><?= number_format($sRow['subTotal'],2) ?></center></span>
                         <input type="hidden" class="itemSubTotal form_quoSP form-control subTotalGroup" id="selected-<?= $sRow['id'] ?>-subTotal" name="QuotationDetail[subTotal][]" value="<?= $sRow['subTotal'] ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <b> 
                            <input type="checkbox" name="QuotationDetail[task][]" id="task" class="task"  value="<?= $sRow['service_part_id'] ?>" <?php if( $sRow['task'] == 1 ): ?> checked='checked' <?php endif; ?> /> Pending Service ?
                        </b> 
                        <span class="remove-button">
                            <a href="javascript:removeSelectedItem(<?= $sRow['id'] ?>)" id="quoDeleteItemList">&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
                        </span>
                    </div>
                </div>
                <br/><hr/>
            </div>
            <?php endforeach; ?>

            <?php foreach($getPart as $pRow): ?>
            <div class="col-md-12 item-<?= $pRow['id'] ?>">    
                <div class="row item">
                    
                    <div class="col-md-3">
                        <span class="selectedLabel"><center><?= strtoupper($pRow['product_name']) ?></center></span>
                        <input type="hidden" class="form_quoSP form-control" id="selected-<?= $pRow['id'] ?>-service" value="<?= strtoupper($pRow['product_name']) ?>" readonly>
                        <input type="hidden" class="servicePartId form-control" name="QuotationDetail[service_part_id][]" value="1-<?= $pRow['productId'] ?>" readonly>

                    </div>

                    <div class="col-md-2">
                        <span class="selectedLabel"><center><?= $pRow['quantity'] ?></center></span>
                        <input type="hidden" class="itemQty form_quoSP form-control" id="selected-<?= $pRow['id'] ?>-itemQty" name="QuotationDetail[quantity][]" value="<?= $pRow['quantity'] ?>" readonly onchange="updateSelectedItemSubtotal(<?= $pRow['id'] ?>)">
                    </div>

                    <div class="col-md-2">
                        <span class="selectedLabel"><center><?= number_format($pRow['selling_price'],2) ?></center></span>
                        <input type="hidden" class="itemPriceValue form_quoSP form-control" id="selected-<?= $pRow['id'] ?>-itemPrice" name="QuotationDetail[selling_price][]" value="<?= $pRow['selling_price'] ?>" readonly onchange="updateSelectedItemSubtotal(<?= $pRow['id'] ?>)">
                    </div>

                    <div class="col-md-2">
                         <span class="selectedLabel"><center><?= number_format($pRow['subTotal'],2) ?></center></span>
                         <input type="hidden" class="itemSubTotal form_quoSP form-control subTotalGroup" id="selected-<?= $pRow['id'] ?>-subTotal" name="QuotationDetail[subTotal][]" value="<?= $pRow['subTotal'] ?>" readonly>
                    </div>

                    <div class="col-md-3">
                        <span class="remove-button">
                            <a href="javascript:removeSelectedItem(<?= $pRow['id'] ?>)" id="quoDeleteItemList">&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
                        </span>
                    </div>
                </div>
                <br/><hr/>
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
                <span class="selectedLabel"><center>Sub-Total</center></span>
                <input type="text" name="Quotation[grand_total]" value="<?= number_format($quotation['grand_total'],2) ?>" class="grandTotal form-control" id="grandTotal" placeholder="Total Price" readonly />
                <br/>

                <span class="selectedLabel"><center>GST(7%)</center></span>
                <input type="hidden" name="gst" class="grandTotal form-control" id="gst" value="<?= $gst ?>" />
                <input type="text" name="Quotation[gst]" class="grandTotal form-control" id="gstResult" value="<?= number_format($quotation['gst'],2) ?>" placeholder="GST Amount" readonly />
                <br/>

                <span class="selectedLabel"><center>Nett Total</center></span>
                <input type="text" name="Quotation[net]" class="grandTotal form-control" id="netTotal" value="<?= number_format($quotation['net'],2) ?>" placeholder="Total Price" readonly />
            </div>
        
        </div>

        <input type="hidden" id='n' value="<?= $getLastId ?>">
        <br/>

    </div>   
 
 </div>

<?php ActiveForm::end(); ?>

<div class="col-md-12">
<hr/>
    <div style="text-align: right;">        
        <?= Html::Button('<li class=\'fa fa-save\'></li> Edit Job-Sheet' , ['class' =>'form-btn btn btn-dark btn-lg',  'id' => 'saveQuotationForm']) ?>
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
</div> -->
​
<!-- <div class="modal fade" id="modal-launcher-part" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
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


