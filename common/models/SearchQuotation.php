<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Quotation;

use yii\db\Query;
/**
 * SearchQuotation represents the model behind the search form about `common\models\Quotation`.
 */
class SearchQuotation extends Quotation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'customer_id', 'branch_id', 'created_by', 'updated_by', 'delete', 'invoice'], 'integer'],
            [['quotation_code', 'date_issue', 'remarks', 'created_at', 'updated_at'], 'safe'],
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
        $query = Quotation::find();

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
        ]);

        $query->andFilterWhere(['like', 'quotation_code', $this->quotation_code])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }

    // get Quotation
    public function getQuotation() 
    {
        $rows = new Query();

        $result = $rows->select(['quotation.id', 'quotation.quotation_code', 'user.fullname as salesPerson', 'customer.fullname', 'customer.carplate', 'branch.code', 'branch.name', 'quotation.date_issue', 'quotation.task', 'quotation.invoice'])
            ->from('quotation')
            ->join('INNER JOIN', 'user', 'quotation.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'quotation.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'quotation.branch_id = branch.id')
            ->where('quotation.delete = 0')
            ->all();

        return $result;
    }

    // get QuotationByDateRange
    public function getQuotationByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select(['quotation.id', 'quotation.quotation_code', 'user.fullname as salesPerson', 'customer.fullname', 'customer.carplate', 'branch.code', 'branch.name', 'quotation.paid', 'quotation.date_issue', 'quotation.task', 'quotation.invoice'])
            ->from('quotation')
            ->join('INNER JOIN', 'user', 'quotation.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'quotation.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'quotation.branch_id = branch.id')
            ->where("quotation.date_issue >= '$date_start'")
            ->andWhere("quotation.date_issue <= '$date_end'")
            ->andWhere('quotation.delete = 0')
            ->all();

        return $result;
    }

    // get id
    public function getQuotationId() 
    {
        $rows = new Query();

        $result = $rows->select(['Max(id) as quotation_id'])
                        ->from('quotation')
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['quotation_id'] + 1;
        
        }else {
            return 0;
        
        }                
    }

    // get branch
    public function getBranch() 
    {
        $rows = new Query();

        $result = $rows->select(['id','code','name as branchList'])
        ->from('branch')
        ->where('id > 1')
        ->all();

        if( count($result) > 0 ) {
            return $result;
        
        }else {
            return 0;
        
        }   
    }

    // get user
    public function getUser() 
    {
        $rows = new Query();

        $result = $rows->select(['user.id', 'role.role', 'user.fullname as userList'])
        ->from('user')
        ->join('INNER JOIN', 'role', 'user.role_id = role.id')
        ->where('user.role_id >= 2')
        ->andWhere('user.role_id <= 3')
        ->all();

        if( count($result) > 0 ) {
            return $result;
        
        }else {
            return 0;
        
        }   
    }

    // get customer
    public function getCustomer() 
    {
        $rows = new Query();

        $result = $rows->select(['id', 'carplate', 'fullname as customerList'])
        ->from('customer')
        ->all();

        if( count($result) > 0 ) {
            return $result;
        
        }else {
            return 0;
        
        }   
    }

    // get services
    public function getServicesList() 
    {
        $rows = new Query();

        $result = $rows->select(['service.id', 'service_category.name', 'service.service_name'])
        ->from('service')
        ->join('INNER JOIN', 'service_category', 'service.service_category_id = service_category.id')
        ->all();

        if( count($result) > 0 ) {
            return $result;
        
        }else {
            return 0;
        
        }   
    }

    // get products
    public function getPartsList() 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.product_id as productId', 'product.product_name', 'category.category', 'supplier.supplier_name'])
        ->from('inventory')
        ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
        ->join('INNER JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
        ->join('INNER JOIN', 'category', 'product.category_id = category.id')
        ->all();

        if( count($result) > 0 ) {
            return $result;
        
        }else {
            return 0;
        
        }   
    }

    // getProcessedQuotation
    public function getProcessedQuotation($quotationId) 
    {
        $rows = new Query();

        $result = $rows->select(['quotation.id', 'quotation.quotation_code', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'customer.carplate', 'customer.race', 'customer.email', 'customer.make', 'customer.model', 'customer.points', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'quotation.date_issue', 'quotation.remarks', 'quotation.grand_total', 'quotation.task', 'quotation.invoice', 'quotation.created_at'])
            ->from('quotation')
            ->join('INNER JOIN', 'user', 'quotation.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'quotation.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'quotation.branch_id = branch.id')
            ->where(['quotation.id' => $quotationId])
            ->one();

        return $result;
    }

    // getProcesssedServices
    public function getProcessedServices($id) 
    {
        $rows = new Query();

        $service = $rows->select(['quotation_detail.id', 'quotation_detail.quotation_id', 'service.service_name', 'quotation_detail.quantity', 'quotation_detail.selling_price', 'quotation_detail.subTotal', 'quotation_detail.task'])
            ->from('quotation_detail')
            ->join('INNER JOIN', 'service', 'quotation_detail.service_part_id = service.id')
            ->where(['quotation_detail.quotation_id' => $id])
            ->andWhere('quotation_detail.type = 0')
            ->all();

        return $service;
    }

    // getProcessedParts
    public function getProcessedParts($id) 
    {
        $rows = new Query();

        $part = $rows->select(['quotation_detail.id', 'product.product_name', 'quotation_detail.quantity', 'quotation_detail.selling_price', 'quotation_detail.subTotal'])
            ->from('quotation_detail')
            ->join('LEFT JOIN', 'inventory', 'quotation_detail.service_part_id = inventory.id')
            ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
            ->where(['quotation_detail.quotation_id' => $id])
            ->andWhere('quotation_detail.type = 1')
            ->all();

        return $part;
    }

    // getProcessedQuotationbyId
    public function getProcessedQuotationbyId($id) 
    {
        $rows = new Query();

        $result = $rows->select(['quotation.id', 'quotation.quotation_code', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'customer.carplate', 'customer.race', 'customer.email', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'quotation.date_issue', 'quotation.remarks', 'quotation.grand_total', 'quotation.branch_id', 'quotation.customer_id', 'quotation.user_id', 'quotation.created_at', 'quotation.created_by', 'quotation.updated_at', 'quotation.updated_by', 'quotation.delete', 'quotation.task'])
            ->from('quotation')
            ->join('INNER JOIN', 'user', 'quotation.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'quotation.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'quotation.branch_id = branch.id')
            ->where(['quotation.id' => $id])
            ->one();

        return $result;
    }

    // getProcessedServicesById
    public function getProcessedServicesById($id) 
    {
        $rows = new Query();

        $service = $rows->select(['quotation_detail.id', 'quotation_detail.quotation_id', 'service.id as serviceId', 'service.service_name', 'quotation_detail.quantity', 'quotation_detail.selling_price', 'quotation_detail.subTotal', 'quotation_detail.task', 'quotation_detail.created_at', 'quotation_detail.created_by', 'quotation_detail.type'])
            ->from('quotation_detail')
            ->join('INNER JOIN', 'service', 'quotation_detail.service_part_id = service.id')
            ->where(['quotation_detail.quotation_id' => $id])
            ->andWhere('quotation_detail.type = 0')
            ->all();

        return $service;
    }

    // getProcessedPartsById
    public function getProcessedPartsById($id) 
    {
        $rows = new Query();

        $part = $rows->select(['quotation_detail.id', 'quotation_detail.quotation_id', 'inventory.id as productId', 'product.product_name', 'quotation_detail.quantity', 'quotation_detail.selling_price', 'quotation_detail.subTotal', 'quotation_detail.task', 'quotation_detail.created_at', 'quotation_detail.created_by', 'quotation_detail.type'])
            ->from('quotation_detail')
            ->join('LEFT JOIN', 'inventory', 'quotation_detail.service_part_id = inventory.id')
            ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
            ->where(['quotation_detail.quotation_id' => $id])
            ->andWhere('quotation_detail.type = 1')
            ->all();

        return $part;
    }

    // getLastId
    public function getLastId($id) 
    {
        $rows= new Query();

        $lastId = $rows->select(['max(id) as id'])
                    ->from('quotation_detail')
                    ->where(['quotation_id' => $id ])
                    ->one();

        return $lastId['id'];
    }

}
