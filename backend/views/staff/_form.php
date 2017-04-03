<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\StaffGroup;
use common\models\DesignatedPosition;
use common\models\Race;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$staffCode = 'EMP'.sprintf('%0003d', $getStaffId); 
$dataStaffGroup = ArrayHelper::map(StaffGroup::find()->where(['status' => 1])->all(),'id', 'name');
$dataDesignatedPosition = ArrayHelper::map(DesignatedPosition::find()->where(['status' => 1])->all(),'id', 'name');
$dataRace = ArrayHelper::map(Race::find()->where(['status' => 1])->all(),'id', 'name');
$dataGender = array('Male' => 'Male', 'Female' => 'Female');
$dataCitizen = array('1' => 'LOCAL', '2' => 'INTERNATIONAL / FOREIGNER');

if(!is_null(Yii::$app->request->get('id')) || Yii::$app->request->get('id') <> ''){
    $id = Yii::$app->request->get('id'); 
}else{
    $id = 0;
}

?>

<?php $form = ActiveForm::begin(['id' => 'arh-form']); ?>

<div class="row" >

    <div class="col-md-7">
        
        <div class="row">
            <div class="search-label-container">
                &nbsp;
                <span class="search-label"><li class="fa fa-edit"></li> Staff Information.</span>
            </div>
            <br/>

            <div class="col-md-6">
                <label class="form_label">Code</label>
                <input type="hidden" name="id" id="id" value="<?= $id ?>" />
                <?= $form->field($model, 'staff_code')->textInput(['class' => 'form_input form-control', 'style' => 'text-align:center; font-weight: bold;', 'readonly' => 'readonly', 'value' => $staffCode, 'id' => 'staffCode' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form_label">Citizenship</label>
                <?= $form->field($model, 'citizenship')->dropdownList(['0' => '- PLEASE SELECT CITIZENSHIP HERE -'] + $dataCitizen, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'id' => 'citizenship', 'data-placeholder' => 'CHOOSE CITIZENSHIP HERE'])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form_label">Department</label>
                <?= $form->field($model, 'staff_group_id')->dropdownList(['0' => '- PLEASE SELECT DEPARTMENT HERE -'] + $dataStaffGroup, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE DEPARTMENT HERE', 'id' => 'staffGroup' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form_label">Designated Position</label>
                <?= $form->field($model, 'designated_position_id')->dropdownList(['0' => '- PLEASE SELECT DESIGNATED POSITION HERE -'] + $dataDesignatedPosition, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE DESIGNATED POSITION HERE', 'id' => 'staffPosition' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form_label">Fullname</label>
                <?= $form->field($model, 'fullname')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Name here.', 'id' => 'staffFullname' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-10">
                <label class="form_label">Address</label>
                <?= $form->field($model, 'address')->textArea(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Address here.', 'id' => 'staffAddress' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-5">
                <label class="form_label">Race</label>
                <?= $form->field($model, 'race_id')->dropdownList(['0' => '- PLEASE SELECT RACE HERE -'] + $dataRace, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE RACE HERE', 'id' => 'staffRace' ])->label(false) ?>
            </div>

            <div class="col-md-5">
                <label class="form_label">Gender</label>
                <?= $form->field($model, 'gender')->dropdownList(['0' => '- PLEASE SELECT GENDER HERE -'] + $dataGender, ['style' => 'width:100%', 'class' => 'form_input select2_single', 'data-placeholder' => 'CHOOSE GENDER HERE', 'id' => 'staffGender' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-5">
                <label class="form_label">Contact Number</label>
                <?= $form->field($model, 'contact_number')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Contact Number here.', 'id' => 'staffContactNo' ])->label(false) ?>
            </div>

            <div class="col-md-5">
                <label class="form_label">Email Address</label>
                <?= $form->field($model, 'email')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Email here.', 'id' => 'staffEmail' ])->label(false) ?>
            </div>

        </div>
        
    </div>

    <div class="col-md-5">
        
        <div class="row">
            <div class="search-label-container">
                &nbsp;
                <span class="search-label"><li class="fa fa-comment"></li> Other Information.</span>
            </div>
            <br/>

        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form_label">NRIC/WP/FIN</label>
                <?= $form->field($model, 'ic_no')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff IC Number here.', 'id' => 'staffNric' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form_label">Rate/Hour</label>
                <?= $form->field($model, 'rate_per_hour')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Rate per Hour here.', 'id' => 'staffRate' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form_label">Basic Salary</label>
                <?= $form->field($model, 'basic')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Basic Salary here.', 'id' => 'staffBasic' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form_label">Allowance</label>
            <?= $form->field($model, 'allowance')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Allowance here.', 'id' => 'staffAllowance' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form_label">Non Tax-Allowance</label>
            <?= $form->field($model, 'non_tax_allowance')->textInput(['class' => 'form_input form-control', 'placeholder' => 'Write Staff Non Tax-Allowance here.', 'id' => 'staffNonTaxAllowance' ])->label(false) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form_label">Levy Supplement</label>
            <?= $form->field($model, 'levy_supplement')->textInput(['class' => 'form_input form-control', 'id' => 'levySupplement', 'placeholder' => 'Write Staff Levy Supplement here.', 'readonly' => 'readonly'])->label(false) ?>
            </div>

        </div>

    </div>

</div>
<br/><hr/>

<?php ActiveForm::end(); ?>

<div class="row">

    <div class="col-md-4">
        <?= Html::Button($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Edit Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary', 'id' => $model->isNewRecord ? 'submitStaffForm' : 'saveStaffForm']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>

</div>
<br/><br/>









