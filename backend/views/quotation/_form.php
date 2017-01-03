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

$dataType = array('' => 'Choose Type', '0' => 'Inactive', '1' => 'Active');

$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;
    
$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'supplier_name');
$dataProduct = ArrayHelper::map(Product::find()->all(), 'id', 'product_name');

$getProductList = Product::find()->all();

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div style="padding-left:25px;" class="row">

    <br/>

    <div class="col-md-3">
        <input type="text" name="quotationCode" value="<?php echo 'QUO' . '-' .  date('Y') . '-' .  substr(uniqid('', true), -5) . $quotationId; ?>" class="form-control" id="quotationCode" readonly="readonly" placeholder="YYYY-MM-DD" style="font-size: 11.5px; font-weight: bold; text-align: center;" />
    </div>
    
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>

</div>

<div style="padding-left:25px;" class="row">

    <br/>

    <div class="col-md-3">
        <label style="font-size: 12px;">Date Issue</label>
        <input type="text" name="" id="expiry_date" class="form-control" readonly="readonly" placeholder="YYYY-MM-DD" style="font-size: 11.5px; font-weight: bold; text-align: center;" />    
    </div>
    
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>

</div>
<br/>


<div style="padding-left: 40px;" class="row">

    <div class="col-md-6">

        <div class="row">

            <div class="col-md-9">
                <label style="font-size: 12px;">Branch</label>
                <select name="branch" class="select3_single" style="width: 100%;">
                    <?php foreach( $getBranchList as $row ): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo strtoupper($row['branchList']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3"></div>
        </div>
        <br/>

        <div class="row">

            <div class="col-md-9">
                <label style="font-size: 12px;">Customer</label>
                <select name="product_id[]" class="select3_single" style="width: 100%; text-transform: uppercase;">
                    <?php foreach( $getCustomerList as $row ): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo strtoupper($row['customerList']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3"></div>
       </div>
       <br/>

        

        <div class="row">

            <div class="col-md-9">
                <label style="font-size: 12px;">Sales Person</label>
                <select name="product_id[]" class="select3_single" style="width: 100%; text-transform: uppercase;">
                    <?php foreach( $getUserList as $row ): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo strtoupper($row['userList']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3"></div>
        </div>
        <br/>

        <div class="row">

            <div class="col-md-9">
                <label for="message">Message (20 chars min, 100 max) :</label>
                <textarea id="message" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>              
            </div>

            <div class="col-md-3"></div>
        </div>
        <br/>

    </div>

    <div class="col-md-6">

        <div class="row">

            <div class="col-md-9">
                <label style="font-size: 12px;">Type</label>
                <select name="product_id[]" class="select3_single" style="width: 100%; text-transform: uppercase;">
                    <?php foreach( $getBranchList as $row ): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo strtoupper($row['branchList']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3"></div>
        </div>
        <br/>

        <div class="row">

            <div class="col-md-9">
                <label style="font-size: 12px;">No. of Services</label>
                <input type="text" name="" class="form-control" placeholder="Enter Number of Services Here " style="font-size: 12px; font-weight: bold; border-radius: 5px;" />                
            </div>

            <div class="col-md-3"></div>
        </div>
        <br/>

        <div class="row">

            <div class="col-md-9">
                <label style="font-size: 12px;">No. of Parts</label>
                <input type="text" name="" class="form-control" placeholder="Enter Number of Parts Here " style="font-size: 12px; font-weight: bold; border-radius: 5px;" />                
            </div>

            <div class="col-md-3"></div>
        </div>
        <br/>

    </div>

</div>
<br/>

<div style="background-color:  red" class="row">
    <div class="col-md-12">a</div>
</div>
<br/>

<div class="row">
    <div class="col-md-12">
        <div>Select Parts/Services</div>
    </div>
</div>

<?php ActiveForm::end(); ?>




















<div class="row">

    <div class="col-md-3"></div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label style="font-size: 12px;">Quantity</label>
        <input type="text" name="quantity[]" class="form-control" required="required" placeholder="Quantity Here" />
    </div>

    <div class="col-md-3">
        <label style="font-size: 12px;">Cost Price</label>
        <input type="text" name="cost_price[]" class="form-control" required="required" placeholder="Cost Price Here" />
    </div>

    <div class="col-md-3">
        <label style="font-size: 12px;">Selling Price</label>
        <input type="text" name="selling_price[]" class="form-control" required="required" placeholder="Selling Price Here" />
    </div>

    <div class="col-md-3">
    <br/>
        <button type="button" class="form-btn add btn btn-link add-more" ><i class='fa fa-plus'></i> Add </button>   
    </div>

    <div >
        <?= $form->field($model, 'created_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'date_imported')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'created_by')->textInput(['type' => 'hidden', 'value' => $userId])->label(false) ?>
    </div>

</div>

<div class="input-group control-group after-add-more"></div>

<div class="copy hide">

<div class="control-group input-group" style="margin-top:10px">

<div class="row">

    <div class="col-md-3">
        
        <label style="font-size: 12px;">Product Name</label>
        <br/>
        <select name="product_id[]" class="form-control" style="width: 100%;">
            <option value="0">Select Product</option>
            <?php foreach( $getProductList as $row ): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></option>
            <?php endforeach; ?>
        </select>

    </div>  

    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>

</div>
<br/>

<div class="row">  

    <div class="col-md-3">
        <label style="font-size: 12px;">Quantity</label>
        <input type="text" name="quantity[]" class="form-control" placeholder="Quantity Here" />
    </div>

    <div class="col-md-3">
        <label style="font-size: 12px;">Cost Price</label>
        <input type="text" name="cost_price[]" class="form-control" placeholder="Cost Price Here" />
    </div>

    <div class="col-md-3">
        <label style="font-size: 12px;">Selling Price</label>
        <input type="text" name="selling_price[]" class="form-control" placeholder="Selling Price Here" />
    </div>

    <div class="col-md-3">
        <br/>
        <button type="button" class="form-btn btn btn-link remove" ><i class='fa fa-minus-circle'></i> Remove </button>
    </div>
    
</div>
<hr/>

</div>

</div>   
<hr/>

<div class="row">

    <div class="col-md-4">
        <?= Html::submitButton($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Update Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>
    
    <div class="col-md-4"></div>

    <div class="col-md-4"></div>

</div>
<br/><br/>