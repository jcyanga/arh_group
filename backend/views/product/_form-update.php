<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Category;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$datetime = date('Y-m-d');

$userId = Yii::$app->user->identity->id;

// ->where(['<>','status','inactive'])

$dataCategory = ArrayHelper::map(Category::find()->all(), 'id', 'category');
?>

<div>
    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data'], 'class' => 'form-inline']); ?>
    
        <div class="search-label-container">
            <span class="search-label"><li class="icon-edit"></li> Fill-up all the field.</span>
        </div>

             <div class="floating-box">
                <?= $form->field($model, 'category_id')->dropDownList($dataCategory)->label('Product Category') ?>
             </div>
             <br/>

             <div class="floating-box">
                <?= $form->field($model, 'product_code')->textInput(['maxlength' => true, 'id' => 'product_code', 'class' => 'span3 m-wrap', 'placeholder' => 'Product Code here...']) ?>
             </div>

             <div class="floating-box">
                <?= $form->field($model, 'product_name')->textInput(['maxlength' => true, 'id' => 'product_name', 'class' => 'span3 m-wrap', 'placeholder' => 'Product Name here...']) ?>
             </div>

             <div class="floating-box">
                <?= $form->field($model, 'unit_of_measure')->textInput(['maxlength' => true, 'id' => 'unit_of_measure', 'class' => 'span3 m-wrap', 'placeholder' => 'Unit of Measure here...']) ?>
             </div>
             <br/>

             <div class="floating-box">
                <?= $form->field($model, 'product_image')->fileInput(['value' => 'Choose', 'style' => 'font-size: 12px;', 'id' => 'product_image', 'class' => 'span3 m-wrap', 'accept' => 'jpg|jpeg|gif|png']) ?> <span style="font-style: italic; color: red; font-size: 11px; font-weight: bold;">(Choose only image-file "jpg|jpeg|png" )</span>
             </div>
             
             <div >
                <?= $form->field($model, 'created_at')->textInput(['type' => 'hidden', 'value' => $datetime])->label(false) ?>
                <?= $form->field($model, 'status')->textInput(['type' => 'hidden', 'value' => '1'])->label(false) ?>
                <?= $form->field($model, 'created_by')->textInput(['type' => 'hidden', 'value' => $userId])->label(false) ?>
             </div>     
             <hr/>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<li class=\'icon-save\'></li> Create New Record' : '<li class=\'icon-save\'></li> Update the Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
                <?= Html::resetButton('<li class=\'icon-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
            </div>

    <?php ActiveForm::end(); ?>
    <br/><br/><br/>
</div>






