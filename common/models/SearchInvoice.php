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

    // get id
    public function getInvoiceId() 
    {
        $rows = new Query();

        $result = $rows->select(['Max(id) as invoice_id'])
                        ->from('invoice')
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['invoice_id'] + 1;
        
        }else {
            return 0;
        
        }                
    }

    // get Invoice
    public function getInvoice() 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.carplate', 'branch.code', 'branch.name', 'invoice.paid', 'invoice.date_issue', 'invoice.task', 'invoice.status'])
            ->from('invoice')
            ->join('INNER JOIN', 'user', 'invoice.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'invoice.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->where('invoice.delete = 0')
            ->all();

        return $result;
    }

    // getInvoiceByDateRange
    public function getInvoiceByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.carplate', 'branch.code', 'branch.name', 'invoice.paid', 'invoice.date_issue', 'invoice.task'])
            ->from('invoice')
            ->join('INNER JOIN', 'user', 'invoice.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'invoice.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->where("invoice.date_issue >= '$date_start'")
            ->andWhere("invoice.date_issue <= '$date_end'")
            ->andWhere('invoice.delete = 0')
            ->all();

        return $result;
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

    // getProcessedtInvoice
    public function getProcessedInvoice($invoiceId) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'customer.carplate', 'customer.race', 'customer.email', 'customer.make', 'customer.model', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'invoice.date_issue', 'invoice.remarks', 'invoice.grand_total', 'invoice.task', 'invoice.status', 'invoice.paid_type'])
            ->from('invoice')
            ->join('INNER JOIN', 'user', 'invoice.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'invoice.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->where(['invoice.id' => $invoiceId])
            ->one();

        return $result;
    }

    // getProcessedServices
    public function getProcessedServices($id) 
    {
        $rows = new Query();

        $service = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'service.service_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal', 'invoice_detail.task'])
            ->from('invoice_detail')
            ->join('INNER JOIN', 'service', 'invoice_detail.service_part_id = service.id')
            ->where(['invoice_detail.invoice_id' => $id])
            ->andWhere('invoice_detail.type = 0')
            ->all();

        return $service;
    }

    // getProcessedParts
    public function getProcessedParts($id) 
    {
        $rows = new Query();

        $part = $rows->select(['invoice_detail.id', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal'])
            ->from('invoice_detail')
            ->join('LEFT JOIN', 'inventory', 'invoice_detail.service_part_id = inventory.id')
            ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
            ->where(['invoice_detail.invoice_id' => $id])
            ->andWhere('invoice_detail.type = 1')
            ->all();

        return $part;
    }

    // getProcessedInvoicebyId
    public function getProcessedInvoicebyId($invoiceId) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.quotation_code', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'customer.carplate', 'customer.points', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'invoice.date_issue', 'invoice.remarks', 'invoice.grand_total', 'invoice.branch_id', 'invoice.customer_id', 'invoice.user_id', 'invoice.paid_type' ])
            ->from('invoice')
            ->join('INNER JOIN', 'user', 'invoice.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'invoice.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->where(['invoice.id' => $invoiceId])
            ->one();

        return $result;
    }

    // getProcessedServicesbyId
    public function getProcessedServicesbyId($id) 
    {
        $rows = new Query();

        $service = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'service.id as serviceId', 'service.service_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal', 'invoice_detail.task'])
            ->from('invoice_detail')
            ->join('INNER JOIN', 'service', 'invoice_detail.service_part_id = service.id')
            ->where(['invoice_detail.invoice_id' => $id])
            ->andWhere('invoice_detail.type = 0')
            ->all();

        return $service;
    }

    // getProcessedPartsbyId
    public function getProcessedPartsbyId($id) 
    {
        $rows = new Query();

        $part = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'inventory.id as productId', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal'])
            ->from('invoice_detail')
            ->join('LEFT JOIN', 'inventory', 'invoice_detail.service_part_id = inventory.id')
            ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
            ->where(['invoice_detail.invoice_id' => $id])
            ->andWhere('invoice_detail.type = 1')
            ->all();

        return $part;
    }

    // getLastId
    public function getLastId($id) 
    {
        $rows= new Query();

        $lastId = $rows->select(['max(id) as id'])
                    ->from('invoice_detail')
                    ->where(['invoice_id' => $id ])
                    ->one();

        return $lastId['id'];
    }

    // getPaidInvoiceById
    public function getPaidInvoiceById($invoiceId,$invoiceNo) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.discount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'customer.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'payment.remarks as paymentRemarks' ])
                    ->from('payment')
                    ->join('LEFT JOIN', 'invoice', 'payment.invoice_id = invoice.id')
                    ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                    ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                    ->join('LEFT JOIN', 'customer', 'payment.customer_id = customer.id')
                    ->where([ 'payment.invoice_id' => $invoiceId ])
                    ->andWhere([ 'payment.invoice_no' => $invoiceNo ])
                    ->one();
        
        return $result;
    }

    // getInvoiceServiceDetail
    public function getInvoiceServiceDetail($invoiceId) 
    {
        $rows = new Query();

        $service = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'service.id as serviceId', 'service.service_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal', 'invoice_detail.task'])
            ->from('invoice_detail')
            ->join('INNER JOIN', 'service', 'invoice_detail.service_part_id = service.id')
            ->where(['invoice_detail.invoice_id' => $invoiceId])
            ->andWhere('invoice_detail.type = 0')
            ->all();

        return $service;
    }

    // getInvoicePartDetail
    public function getInvoicePartDetail($invoiceId) 
    {
        $rows = new Query();

        $part = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'product.id as productId', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal'])
            ->from('invoice_detail')
            ->join('LEFT JOIN', 'inventory', 'invoice_detail.service_part_id = inventory.id')
            ->join('LEFT JOIN', 'product', 'invoice_detail.service_part_id = product.id')
            ->where(['invoice_detail.invoice_id' => $invoiceId])
            ->andWhere('invoice_detail.type = 1')
            ->all();

        return $part;
    }

    // getPaidMultipleInvoiceById
    public function getPaidMultipleInvoiceById($invoiceId,$invoiceNo) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.discount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'customer.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'payment.remarks as paymentRemarks', 'invoice.invoice_no as multipleInvoiceNo' ])
                ->from('payment')
                ->join('LEFT JOIN', 'invoice', 'payment.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                ->join('LEFT JOIN', 'customer', 'payment.customer_id = customer.id')
                ->where([ 'payment.invoice_id' => $invoiceId ])
                ->andWhere([ 'invoice.invoice_no' => $invoiceNo ])
                ->all();
        
        return $result;
    }

    // checkInvoiceIfExist
    public function checkInvoice($invoiceId,$invoiceNo,$customerId) 
    {
        $rows = new Query();

        $result = Payment::find()->where(['invoice_id' => $invoiceId])->andWhere(['invoice_no' => $invoiceNo])->andWhere(['customer_id' => $customerId])->all();
        
        if( count($result) > 0 ) {
            return $result;
        }else{
            return 0;
        }
    }

    // getPaidInvoice
    public function getPaidInvoice($lastId,$invoiceId,$invoiceNo,$customerId) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.discount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'customer.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'payment.remarks as paymentRemarks' ])
                    ->from('payment')
                    ->join('LEFT JOIN', 'invoice', 'payment.invoice_id = invoice.id')
                    ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                    ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                    ->join('LEFT JOIN', 'customer', 'payment.customer_id = customer.id')
                    ->where([ 'payment.id' => $lastId ])
                    ->andWhere([ 'payment.invoice_id' => $invoiceId ])
                    ->andWhere([ 'payment.invoice_no' => $invoiceNo ])
                    ->andWhere([ 'payment.customer_id' => $customerId ])
                    ->one();
        
        return $result;
    }

    // checkMultipleInvoiceIfExist
    public function checkMultipleInvoice($mInvoiceId,$invoiceNo,$mCustomerId) 
    {
        $rows = new Query();

        $result = Payment::find()->where(['invoice_id' => $mInvoiceId])->andWhere(['invoice_no' => $invoiceNo])->andWhere(['customer_id' => $mCustomerId])->all();
        
        if( count($result) > 0 ) {
            return $result;
        }else{
            return 0;
        }

    }

    // getPaidMultipleInvoice
    public function getPaidMultipleInvoice($getId,$invoiceId,$invoiceNo,$customerId) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.discount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'customer.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'payment.remarks as paymentRemarks', 'invoice.invoice_no as multipleInvoiceNo' ])
                ->from('payment')
                ->join('LEFT JOIN', 'invoice', 'payment.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                ->join('LEFT JOIN', 'customer', 'payment.customer_id = customer.id')
                ->where([ 'payment.id' => $getId ])
                ->andWhere([ 'payment.invoice_id' => $invoiceId ])
                ->andWhere([ 'payment.customer_id' => $customerId ])
                ->all();
        
        return $result;
    }

}
