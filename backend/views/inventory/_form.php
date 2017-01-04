<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Supplier;
use common\models\Product;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$member_list = array('0' => 'No', '1' => 'Yes');

$datetime = date('Y-m-d h:i:s');

$userId = Yii::$app->user->identity->id;

$dataSupplier = ArrayHelper::map(Supplier::find()->all(), 'id', 'supplier_name');
$dataProduct = ArrayHelper::map(Product::find()->all(), 'id', 'product_name');

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Parts Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label style="font-size: 12px;">Parts-Supplier</label>
        <?= $form->field($model, 'supplier_id')->dropDownList($dataSupplier, ['class' => 'select2_single', 'style' => 'width: 100%;'])->label(false) ?>
    </div>
    
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>
    <div class="col-md-3"></div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label style="font-size: 12px;">Product Name</label>
        <select name="product_id[]" class="select2_single" style="width: 100%;">
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
        <div style="padding-top: 30px;">
        <a href="#" class="form-btn add-more"><i class="fa fa-plus"></i> Add</a>
        </div>  
    </div>

    <div >
        <?= $form->field($model, 'created_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'date_imported')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'created_by')->textInput(['type' => 'hidden', 'value' => $userId])->label(false) ?>
    </div>

</div>
<hr/>

<div class="input-group control-group after-add-more"></div>

<div class="copy hide " >

<div class="control-group" >

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
        <div style="padding-top: 30px;">
        <a href="#" class="form-btn remove"><i class="fa fa-trash"></i> Remove</a>
        </div>  
    </div>
    
</div>
<hr/>

</div>

</div>

<div class="row">

    <div class="col-md-4">
        <?= Html::submitButton($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Update Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>
    
    <div class="col-md-4"></div>

    <div class="col-md-4"></div>

</div>
<br/><br/>

<?php ActiveForm::end(); ?>




<!-- <button type="button" class="form-btn add btn btn-link add-more" ><i class='fa fa-plus'></i> Add </button>  -->


<!-- <div class="input-group control-group after-add-more"></div>

        
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
<hr/> -->