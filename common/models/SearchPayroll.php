<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Payroll;

use yii\db\Query;
/**
 * SearchPayroll represents the model behind the search form about `common\models\Payroll`.
 */
class SearchPayroll extends Payroll
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'overtime_hours', 'created_by', 'updated_by'], 'integer'],
            [['ic_no', 'pay_date', 'prepared_by', 'approved_by', 'created_at', 'updated_at'], 'safe'],
            [['basic', 'rate_per_hour', 'commission', 'allowance', 'employees_cpf', 'employers_cpf', 'sinda', 'advance_loan', 'income_tax', 'reimbursement'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Payroll::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'pay_date' => $this->pay_date,
            'basic' => $this->basic,
            'overtime_hours' => $this->overtime_hours,
            'rate_per_hour' => $this->rate_per_hour,
            'commission' => $this->commission,
            'allowance' => $this->allowance,
            'employees_cpf' => $this->employees_cpf,
            'employers_cpf' => $this->employers_cpf,
            'sinda' => $this->sinda,
            'advance_loan' => $this->advance_loan,
            'income_tax' => $this->income_tax,
            'reimbursement' => $this->reimbursement,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'ic_no', $this->ic_no])
            ->andFilterWhere(['like', 'prepared_by', $this->prepared_by])
            ->andFilterWhere(['like', 'approved_by', $this->approved_by]);

        return $dataProvider;
    }

    // Search box result.
    public function searchStaffName($staffId) 
    {
        $rows = new Query();

        $result = $rows->select(['payroll.id', 'payroll.staff_id', 'staff.fullname', 'payroll.pay_date', 
            'payroll.basic'])
                    ->from('payroll')
                    ->join('INNER JOIN', 'staff', 'payroll.staff_id = staff.id')
                    ->where(['like', 'payroll.staff_id', $staffId])
                    ->all();

        return $result;  
    }

    // get all payroll.
    public function getPayrolls() 
    {
        $rows = new Query();

        $result = $rows->select(['payroll.id', 'payroll.staff_id', 'staff.fullname', 'payroll.pay_date', 
            'payroll.basic'])
                    ->from('payroll')
                    ->join('INNER JOIN', 'staff', 'payroll.staff_id = staff.id')
                    ->all();

        return $result;  
    }

    // Search if with same name.
    public function getPayrollSameName($staffId,$payDate) 
    {
       $rows = new Query();
    
       $result = $rows->select(['staff_id'])
         ->from('payroll')
         ->where(['staff_id' => $staffId])
         ->andWhere(['pay_date' => $payDate])
         ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }

    // get payroll by id.
    public function getPayrollById($id) 
    {
        $rows = new Query();

        $result = $rows->select(['payroll.id', 'payroll.staff_id', 'staff.fullname', 'payroll.ic_no', 'payroll.pay_date', 
            'payroll.basic', 'payroll.overtime_hours', 'payroll.rate_per_hour', 'payroll.commission', 'payroll.allowance', 'payroll.employees_cpf', 'payroll.employers_cpf', 'payroll.sinda', 'payroll.advance_loan', 'payroll.income_tax', 'payroll.reimbursement', 'payroll.prepared_by', 'payroll.approved_by', 'payroll.created_at'])
                    ->from('payroll')
                    ->join('INNER JOIN', 'staff', 'payroll.staff_id = staff.id')
                    ->where(['payroll.id' => $id])
                    ->one();

        return $result;  
    }
}
