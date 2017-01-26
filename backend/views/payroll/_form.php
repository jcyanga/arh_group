<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use common\models\Staff;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */

$dateNow = date('Y-m-d');
$userId = Yii::$app->user->identity->id;
$getStaff = Staff::find()->all();

?>

<?php $form = ActiveForm::begin(['id' => 'demo-form2', 'class' => 'form-inline']); ?>

<div class="row">

    <div class="search-label-container">
        &nbsp;
        <span class="search-label"><li class="fa fa-edit"></li> Payroll Information.</span>
    </div>
    <br/>

    <div class="col-md-4">
        <label class="form_label">Pay Date</label>
        <?= $form->field($model, 'pay_date')->textInput(['class' => 'form_input form-control', 'readonly' => 'readonly', 'id' => 'expiry_date', 'placeholder' => 'YYYY-MM-DD'])->label(false) ?>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-4">
        <label class="form_label">Staff Fullname</label>
        <select name="Quotation[selectedBranch]" class="qSelect select3_single">
            <option value="0">SEARCH STAFF HERE.</option>
            <?php if( !empty($getStaff) ): ?>
                <?php foreach( $getStaff as $row ): ?>
                    <option value="<?php echo $row['id']; ?>">[ <?php echo $row['staff_code']; ?> ] <?php echo $row['fullname']; ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="0">NO RECORD FOUND.</option>
            <?php endif; ?>
        </select>
    </div>

</div>
<br/>

<div class="row">

    <div class="col-md-6">
        
         <div class="row">
            <div class="col-md-8">
                <label class="form_label">IC No.</label>
                <?= $form->field($model, 'ic_no')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Basic</label>
                <?= $form->field($model, 'basic')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Over-Time Hours</label>
                <?= $form->field($model, 'overtime_hours')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Rate per Hour</label>
                <?= $form->field($model, 'rate_per_hour')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Commission</label>
                <?= $form->field($model, 'commission')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Allowance</label>
                <?= $form->field($model, 'allowance')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Employees CPF.</label>
                <?= $form->field($model, 'employees_cpf')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>

    </div>

    <div class="col-md-6">
        
         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Employers CPF.</label>
                <?= $form->field($model, 'employers_cpf')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Sinda</label>
                <?= $form->field($model, 'sinda')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Advance Loan</label>
                <?= $form->field($model, 'advance_loan')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Income Tax</label>
                <?= $form->field($model, 'income_tax')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Reimbursement</label>
                <?= $form->field($model, 'reimbursement')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => '0.00'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Prepared By</label>
                <?= $form->field($model, 'prepared_by')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Who Prepare ?'])->label(false) ?>
            </div>
         </div>
         <br/>

         <div class="row">
            <div class="col-md-8">
                <label class="form_label">Approved By</label>
                <?= $form->field($model, 'approved_by')->textInput(['class' => 'form_input form-control', 'required' => 'required', 'placeholder' => 'Who Approve ?'])->label(false) ?>
            </div>
         </div>
         <br/>

    </div>

</div>
<hr/>

    <div>
        <?= $form->field($model, 'created_at')->textInput(['type' => 'hidden', 'value' => $dateNow])->label(false) ?>
        <?= $form->field($model, 'created_by')->textInput(['type' => 'hidden', 'value' => $userId])->label(false) ?>
        <?= $form->field($model, 'updated_at')->textInput(['type' => 'hidden', 'value' => $dateNow])->label(false) ?>
        <?= $form->field($model, 'updated_by')->textInput(['type' => 'hidden', 'value' => $userId])->label(false) ?>
    </div>

<div class="row">

    <div class="col-md-4">
        <?= Html::submitButton($model->isNewRecord ? '<li class=\'fa fa-save\'></li> Save New Record' : '<li class=\'fa fa-save\'></li> Update Record', ['class' => $model->isNewRecord ? 'form-btn btn btn-primary' : 'form-btn btn btn-primary']) ?>
        <?= Html::resetButton('<li class=\'fa fa-undo\'></li> Reset All Record', ['class' => 'form-btn btn btn-danger']) ?>
    </div>
    
</div>
<br/><br/>

<?php ActiveForm::end(); ?>









