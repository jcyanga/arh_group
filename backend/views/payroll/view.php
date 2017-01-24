<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = 'View Payroll';
 
?>

<div class="row form-container">
<br/>

 <div class="col-md-12 col-sm-12 col-xs-12">
    
 <div class="form-title-container">
    <span class="form-header"><h4>View Payroll Information</h4></span>
 </div>      
 <hr/>

 <div class="col-md-12">
    <div style="text-align: right;">
        <?= Html::a( '<i class="fa fa-backward"></i> Back to previous page', Yii::$app->request->referrer, ['class' => 'form-btn btn btn-default']); ?>

        <?= Html::a( '<i class="fa fa-pencil-square"></i> Update', '?r=payroll/update&id=' . $model['id'], ['class' => 'form-btn btn btn-info']); ?>

        <?= Html::a( '<i class="fa fa-trash"></i> Delete', '?r=payroll/delete-column&id=' . $model['id'], ['class' => 'form-btn btn btn-danger', 'onclick' => 'return deleteConfirmation()']); ?>
    </div>
 </div>    
 <br/>

    <div class="tbl-container viewDesign">
        <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Staff',
                'value' => $model['fullname'],
            ], 
            'ic_no',
            [
                'label' => 'Pay Date',
                'value' => date('m-d-Y', strtotime($model['pay_date'])),
            ], 
            [
                'label' => 'Basic',
                'value' => $model['basic'].'.00',
            ], 
            [
                'label' => 'Overtime Hours',
                'value' => $model['overtime_hours'].' hrs.',
            ], 
            [
                'label' => 'Rate Per Hour',
                'value' => $model['rate_per_hour'].'.00',
            ], 
            [
                'label' => 'Commission',
                'value' => $model['commission'].'.00',
            ], 
            [
                'label' => 'Allowance',
                'value' => $model['allowance'].'.00',
            ], 
            [
                'label' => 'Employees CPF',
                'value' => $model['employees_cpf'].'.00',
            ], 
            [
                'label' => 'Employers CPF',
                'value' => $model['employers_cpf'].'.00',
            ], 
            [
                'label' => 'Sinda',
                'value' => $model['sinda'].'.00',
            ], 
            [
                'label' => 'Advance Loan',
                'value' => $model['advance_loan'].'.00',
            ], 
            [
                'label' => 'Income Tax',
                'value' => $model['income_tax'].'.00',
            ], 
            [
                'label' => 'Reimbursement',
                'value' => $model['reimbursement'].'.00',
            ], 
            'prepared_by',
            'approved_by',
            [
                'label' => 'Created At',
                'value' => date('m-d-Y', strtotime($model['created_at'])),
            ], 
        ],
        ]) ?>
        <br/>
    </div>   
 
 </div>

</div>
<br/>



