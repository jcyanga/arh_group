<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

use yii\db\Query;
/**
 * SearchCustomer represents the model behind the search form about `common\models\Customer`.
 */
class SearchCustomer extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {

        
        // , 'is_blacklist', 'is_member', created_by', 'updated_by'
        return [
            [['id'], 'integer'],
            [['fullname', 'role', 'ic', 'password', 'password_hash', 'auth_key', 'race', 'carplate', 'address', 'hanphone_no', 'office_no', 'email', 'make', 'model', 'remarks', 'points', 'member_expiry', 'status', 'is_blacklist', 'is_member', 'created_by', 'created_at', 'updated_at', 'deleted'], 'safe'],
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
        $query = Customer::find();

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
            'is_blacklist' => $this->is_blacklist,
            'is_member' => $this->is_member,
            'points' => $this->points,
            'member_expiry' => $this->member_expiry,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'race', $this->race])
            ->andFilterWhere(['like', 'carplate', $this->carplate])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'hanphone_no', $this->hanphone_no])
            ->andFilterWhere(['like', 'office_no', $this->office_no])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'make', $this->make])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'remarks', $this->model]);

        return $dataProvider;
    }

    // Search box result
    public function searchCustomerFullname($fullname) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('customer')
                    ->where(['like', 'fullname', $fullname])
                    ->all();

        return $result;            
    }

    // Search if with same name.
    public function getNameAndEmail($fullname, $email) 
    {
       $rows = new Query();
    
       $result = $rows->select(['fullname', 'email'])
        ->from('customer')
        ->where(['fullname' => $fullname])
        ->andWhere(['email' => $email])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }

    // get customer quotation by search
    public function getCustomerQuotationBySearch($keyword) 
    {
        $rows = new Query();

        $result = $rows->select([ 'quotation.id as quotationId', 'quotation.quotation_code as quotationCode', 'quotation.user_id', 'user.fullname as salesPerson', 'quotation.customer_id', 'customer.fullname as customerName', 'customer.carplate', 'quotation.branch_id', 'branch.name', 'quotation.date_issue', 'quotation.grand_total', 'quotation.remarks as quotationRemarks', 'quotation_detail.id as quotationDetailId', 'quotation_detail.service_part_id', 'category.category', 'product.product_name', 'inventory.selling_price', 'quotation_detail.quantity', 'quotation_detail.selling_price as quotationPartsPrice', 'quotation_detail.subTotal' ])
                ->from('quotation')
                ->join('LEFT JOIN', 'user', 'quotation.user_id = user.id')
                ->join('LEFT JOIN', 'customer', 'quotation.customer_id = customer.id')
                ->join('LEFT JOIN', 'branch', 'quotation.branch_id = branch.id')
                ->join('LEFT JOIN', 'quotation_detail', 'quotation.id = quotation_detail.quotation_id')
                ->join('LEFT JOIN', 'inventory', 'quotation_detail.service_part_id = inventory.id')
                ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
                ->join('LEFT JOIN', 'category', 'product.category_id = category.id')
                ->where(['LIKE', 'customer.fullname', $keyword ])
                ->orWhere(['LIKE', 'customer.carplate', $keyword ])
                ->orWhere(['LIKE', 'product.product_name',  $keyword ])
                ->orderBy('date_issue','desc')
                ->all();

        return $result;
    }

    // get customer invoice by search
    public function getCustomerInvoiceBySearch($keyword) 
    {
        $rows = new Query();

        $result = $rows->select([ 'invoice.id as invoiceId', 'invoice.invoice_no as invoiceNo', 'invoice.user_id', 'invoice.customer_id', 'customer.fullname as customerName', 'customer.carplate', 'invoice.date_issue', 'invoice.grand_total as grandTotal', 'invoice.remarks as invoiceRemarks', 'invoice.paid', 'user.fullname as salesPerson', 'invoice.paid_type' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'customer', 'invoice.customer_id = customer.id')
                ->where(['LIKE', 'customer.fullname', $keyword ])
                ->orWhere(['LIKE', 'customer.carplate', $keyword ])
                ->groupBy('invoice_no')
                ->orderBy('date_issue','desc')
                ->all();

        return $result;
    }

    // get customer redeem points
    public function getRedeemPoints($id) 
    {
        $rows = new Query();

        $result = $rows->select(['id', 'invoice_no', 'points_redeem', 'payment_date', 'payment_time'])
                    ->from('payment')
                    ->where(['customer_id' => $id])
                    ->all();

        return $result;
    }

}
