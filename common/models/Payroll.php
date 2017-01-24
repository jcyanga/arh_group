<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payroll".
 *
 * @property integer $id
 * @property integer $staff_id
 * @property string $ic_no
 * @property string $pay_date
 * @property double $basic
 * @property integer $overtime_hours
 * @property double $rate_per_hour
 * @property double $commission
 * @property double $allowance
 * @property double $employees_cpf
 * @property double $employers_cpf
 * @property double $sinda
 * @property double $advance_loan
 * @property double $income_tax
 * @property double $reimbursement
 * @property string $prepared_by
 * @property string $approved_by
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Payroll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payroll';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id', 'ic_no', 'pay_date', 'basic', 'overtime_hours', 'rate_per_hour', 'commission', 'allowance', 'employees_cpf', 'employers_cpf', 'sinda', 'advance_loan', 'income_tax', 'reimbursement', 'prepared_by', 'approved_by', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['staff_id', 'overtime_hours', 'created_by', 'updated_by'], 'integer'],
            [['pay_date', 'created_at', 'updated_at'], 'safe'],
            [['basic', 'rate_per_hour', 'commission', 'allowance', 'employees_cpf', 'employers_cpf', 'sinda', 'advance_loan', 'income_tax', 'reimbursement'], 'number'],
            [['ic_no', 'prepared_by', 'approved_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff',
            'ic_no' => 'Ic No',
            'pay_date' => 'Pay Date',
            'basic' => 'Basic',
            'overtime_hours' => 'Overtime Hours',
            'rate_per_hour' => 'Rate Per Hour',
            'commission' => 'Commission',
            'allowance' => 'Allowance',
            'employees_cpf' => 'Employees Cpf',
            'employers_cpf' => 'Employers Cpf',
            'sinda' => 'Sinda',
            'advance_loan' => 'Advance Loan',
            'income_tax' => 'Income Tax',
            'reimbursement' => 'Reimbursement',
            'prepared_by' => 'Prepared By',
            'approved_by' => 'Approved By',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
