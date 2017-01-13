<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Invoice;

use yii\db\Query;
/**
 * SearchInvoice represents the model behind the search form about `common\models\Invoice`.
 */
class SearchInvoice extends Invoice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'customer_id', 'branch_id', 'created_by', 'updated_by', 'delete', 'task', 'paid'], 'integer'],
            [['invoice_no', 'date_issue', 'remarks', 'created_at', 'updated_at'], 'safe'],
            [['grand_total'], 'number'],
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
        $query = Invoice::find();

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
            'user_id' => $this->user_id,
            'customer_id' => $this->customer_id,
            'branch_id' => $this->branch_id,
            'date_issue' => $this->date_issue,
            'grand_total' => $this->grand_total,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'delete' => $this->delete,
            'task' => $this->task,
            'paid' => $this->paid,
        ]);

        $query->andFilterWhere(['like', 'invoice_no', $this->invoice_no])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }

    // getLastInvoice
    public function getInvoice() {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.carplate', 'branch.code', 'branch.name', 'invoice.paid', 'invoice.date_issue', 'invoice.task'])
            ->from('invoice')
            ->join('INNER JOIN', 'user', 'invoice.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'invoice.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->where('invoice.delete = 0')
            ->where('invoice.paid = 0')
            ->all();

        return $result;
    }
}
