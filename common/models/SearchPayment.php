<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Payment;
use yii\db\Query;

/**
 * SearchPayment represents the model behind the search form about `common\models\Payment`.
 */
class SearchPayment extends Payment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'invoice_id', 'payment_method', 'points_earned', 'points_redeem', 'status'], 'integer'],
            [['amount', 'discount'], 'number'],
            [['payment_type', 'remarks', 'payment_date', 'payment_time'], 'safe'],
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
        $query = Payment::find();

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
            'invoice_id' => $this->invoice_id,
            'amount' => $this->amount,
            'discount' => $this->discount,
            'payment_method' => $this->payment_method,
            'points_earned' => $this->points_earned,
            'points_redeem' => $this->points_redeem,
            'payment_date' => $this->payment_date,
            'payment_time' => $this->payment_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'payment_type', $this->payment_type])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }

    // get total daily sales
    public function getTotalDailySales()
    {
       $rows = new Query();
       
       $result = $rows->select([ 'sum(payment.amount) as total' ])
                    ->from('payment')
                    ->join('LEFT JOIN', 'invoice', 'payment .invoice_id = invoice.id')
                    ->join('LEFT JOIN', 'payment_type', 'payment.payment_type = payment_type.id')
                    ->where('invoice.paid = 1')
                    ->andWhere('invoice.status = 1')
                    ->andWhere(['payment.payment_date' => date('Y-m-d')])
                    ->one();  

        if( count($result) > 0 ) {
            return $result;  

        }else{
            return false;
        }                  
    }

    // get total daily cash sales
    public function getTotalDailyCashSales()
    {
       $rows = new Query();
       
       $result = $rows->select([ 'sum(payment.amount) as totalCashPayment', 'payment_type.name' ])
                    ->from('payment')
                    ->join('LEFT JOIN', 'invoice', 'payment .invoice_id = invoice.id')
                    ->join('LEFT JOIN', 'payment_type', 'payment.payment_type = payment_type.id')
                    ->where('invoice.paid = 1')
                    ->andWhere('invoice.status = 1')
                    ->andWhere('payment.payment_type = 1')
                    ->andWhere(['payment.payment_date' => date('Y-m-d')])
                    ->one();  

        if( count($result) > 0 ) {
            return $result;  

        }else{
            return false;
        }                  
    }

    // get total daily creditcard sales
    public function getTotalDailyCreditCardSales()
    {
       $rows = new Query();
       
       $result = $rows->select([ 'sum(payment.amount) as totalCrediCardPayment', 'payment_type.name' ])
                    ->from('payment')
                    ->join('LEFT JOIN', 'invoice', 'payment .invoice_id = invoice.id')
                    ->join('LEFT JOIN', 'payment_type', 'payment.payment_type = payment_type.id')
                    ->where('invoice.paid = 1')
                    ->andWhere('invoice.status = 1')
                    ->andWhere('payment.payment_type = 2')
                    ->andWhere(['payment.payment_date' => date('Y-m-d')])
                    ->one();  

        if( count($result) > 0 ) {
            return $result;  

        }else{
            return 0;
        }                  
    }

    // get total daily nets sales
    public function getTotalDailyNetsSales()
    {
       $rows = new Query();
       
       $result = $rows->select([ 'sum(payment.amount) as totalNetsPayment', 'payment_type.name' ])
                    ->from('payment')
                    ->join('LEFT JOIN', 'invoice', 'payment .invoice_id = invoice.id')
                    ->join('LEFT JOIN', 'payment_type', 'payment.payment_type = payment_type.id')
                    ->where('invoice.paid = 1')
                    ->andWhere('invoice.status = 1')
                    ->andWhere('payment.payment_type = 3')
                    ->andWhere(['payment.payment_date' => date('Y-m-d')])
                    ->one();  

        if( !empty($result) ) {
            return $result;  

        }else{
            return 0;
        }                  
    }

}
