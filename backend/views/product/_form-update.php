<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Category;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$datetime = date('Y-m-d h:i:s');
$userId = Yii::$app->user->identity->id;
$dataCategory = ArrayHelper::map(Category::find()->all(), 'id', 'category');

?>

<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data'], 'id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Product Information.</span>
    </div>
    <br/>

    <div class="col-md-3">
        <label class="form_label">Product Category</label>
        <?= $form->field($model, 'category_id')->dropDownList($dataCategory,['class' => 'form_input form-control'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label class="form_label">Product Code</label>
        <?= $form->field($model, 'product_code')->textInput(['class' => 'form_input form-control', 'readonly' => 'readonly'])->label(false) ?>
    </div>
    
    <div class="col-md-3">
        <label class="form_label">Product Name</label>
        <?= $form->field($model, 'product_name')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Product Name here.'])->label(false) ?>
    </div>

    <div class="col-md-3">
        <label class="form_label">Unit of Measure</label>
        <?= $form->field($model, 'unit_of_measure')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Write Unit of Measure here.'])->label(false) ?>
    </div>

    <div class="col-md-3"></div>

</div>
<br/>

<div class="row">

    <div class="col-md-3">
        <label class="form_label">Product Image</label>
        <br/>
        <img src="assets/products/<?php echo $model->product_image; ?>" id="productImg" alt="<?php echo $model->product_image; ?>" class="img-square "></img>
        <hr/>
        <?= $form->field($model, 'product_image')->fileInput(['value' => $model->product_image, 'accept' => 'jpg|jpeg|gif|png'])->label(false) ?>
    </div>

    <div >
        <input type="hidden" name="before_productImg" value="<?php echo $model->product_image; ?>" />
        <?= $form->field($model, 'created_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
        <?= $form->field($model, 'status')->textInput(['type' => 'hidden', 'value' => '1'])->label(false) ?>
        <?= $form->field($model, 'created_by')->textInput(['type' => 'hidden', 'value' => $userId])->label(false) ?>
    </div>

</div>
<hr/>

<div class="row">

    <div class="col-md-4">
        <?= Html::submitButton($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Update Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>

<?php ActiveForm::end(); ?>













