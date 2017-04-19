<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Invoice;
use common\models\InvoiceDetail;

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

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'car_information.carplate', 'branch.code', 'branch.name', 'invoice.paid', 'invoice.date_issue', 'invoice.task', 'invoice.status'])
            ->from('invoice')
            ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
            ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->where('invoice.delete = 0')
            ->all();

        return $result;
    }

    // getInvoiceByDateRange
    public function getInvoiceByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'car_information.carplate', 'branch.code', 'branch.name', 'invoice.paid', 'invoice.date_issue', 'invoice.task', 'invoice.status'])
            ->from('invoice')
            ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
            ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->where("invoice.date_issue >= '$date_start'")
            ->andWhere("invoice.date_issue <= '$date_end'")
            ->andWhere('invoice.delete = 0')
            ->all();

        return $result;
    }

    // get getInvoiceByCustomerInformation
    public function getInvoiceByCustomerInformation($customerName,$vehicleNumber) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'car_information.carplate', 'branch.code', 'branch.name', 'invoice.paid', 'invoice.date_issue', 'invoice.task', 'invoice.status'])
            ->from('invoice')
            ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
            ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->where(['LIKE', 'customer.fullname', $customerName])
            ->andWhere(['LIKE', 'car_information.carplate', $vehicleNumber])
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
        ->join('LEFT JOIN', 'role', 'user.role_id = role.id')
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

        $result = $rows->select(['id', 'carplate as customerList'])
        ->from('car_information')
        ->groupBy('car_information.carplate')
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

        $result = $rows->select(['product.id', 'product.product_name', 'product.quantity', 'product.selling_price', 'category.category', 'supplier.supplier_name'])
        ->from('product')
        ->join('INNER JOIN', 'supplier', 'product.supplier_id = supplier.id')
        ->join('INNER JOIN', 'category', 'product.category_id = category.id')
        ->where(['product.status' => 1])
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

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'car_information.carplate', 'car_information.points', 'customer.race_id', 'race.name as raceName', 'customer.email', 'car_information.make', 'car_information.model', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'invoice.date_issue', 'invoice.remarks', 'invoice.grand_total', 'invoice.gst', 'invoice.net', 'invoice.mileage', 'invoice.task', 'invoice.status', 'invoice.paid_type', 'invoice.time_created', 'invoice.paid', 'invoice.balance_amount', 'invoice.come_in', 'invoice.come_out', 'customer.type', 'customer.company_name', 'customer.uen_no', 'customer.nric', 'car_information.engine_no', 'car_information.chasis', 'car_information.year_mfg', 'invoice.discount_amount', 'invoice.discount_remarks', 'invoice.branch_id', 'invoice.user_id', 'invoice.customer_id', 'invoice.quotation_code' ])
            ->from('invoice')
            ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
            ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
            ->where(['invoice.id' => $invoiceId])
            ->one();

        return $result;
    }

    // getProcessedServices
    public function getProcessedServices($id) 
    {
        $rows = new Query();

        $service = InvoiceDetail::find()->where(['invoice_id' => $id, 'type' => 0])->all();

        return $service;
    }

    // getProcessedParts
    public function getProcessedParts($id) 
    {
        $rows = new Query();

        $part = $rows->select(['invoice_detail.id', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal'])
            ->from('invoice_detail')
            ->join('INNER JOIN', 'product', 'invoice_detail.service_part_id = product.id')
            ->where(['invoice_detail.invoice_id' => $id, 'invoice_detail.type' => 1])
            ->all();

        return $part;
    }

    // getProcessedInvoicebyId
    public function getProcessedInvoicebyId($invoiceId) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'car_information.carplate', 'car_information.points', 'customer.race_id', 'race.name as raceName', 'customer.email', 'car_information.make', 'car_information.model', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'invoice.date_issue', 'invoice.remarks', 'invoice.grand_total', 'invoice.gst', 'invoice.net', 'invoice.mileage', 'invoice.task', 'invoice.status', 'invoice.paid_type', 'invoice.time_created', 'invoice.paid', 'invoice.balance_amount', 'invoice.come_in', 'invoice.come_out', 'customer.type', 'customer.company_name', 'customer.uen_no', 'customer.nric', 'car_information.engine_no', 'car_information.chasis', 'car_information.year_mfg', 'invoice.discount_amount', 'invoice.discount_remarks', 'invoice.branch_id', 'invoice.user_id', 'invoice.customer_id', 'invoice.quotation_code' ])
            ->from('invoice')
            ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
            ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
            ->where(['invoice.id' => $invoiceId])
            ->one();

        return $result;
    }

    // getProcessedServicesbyId
    public function getProcessedServicesbyId($id) 
    {
        $rows = new Query();

        $service = InvoiceDetail::find()->where(['invoice_id' => $id, 'type' => 0])->all();

        return $service;
    }

    // getProcessedPartsbyId
    public function getProcessedPartsbyId($id) 
    {
        $rows = new Query();

        $part = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'product.id as productId', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal'])
            ->from('invoice_detail')
            ->join('LEFT JOIN', 'product', 'invoice_detail.service_part_id = product.id')
            ->where(['invoice_detail.invoice_id' => $id, 'invoice_detail.type' => 1 ])
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

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'car_information.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'car_information.make', 'car_information.model', 'car_information.points', 'payment.remarks as paymentRemarks', 'invoice.created_at', 'payment_type.name as paymenttypeName', 'invoice.time_created', 'invoice.gst', 'invoice.net', 'invoice.mileage', 'payment.net_with_interest', 'invoice.paid', 'invoice.updated_by', 'invoice.delete', 'invoice.time_created', 'invoice.come_in', 'invoice.come_out', 'customer.type', 'customer.company_name', 'customer.uen_no', 'customer.nric', 'car_information.engine_no', 'car_information.chasis', 'car_information.year_mfg', 'invoice.discount_amount', 'invoice.discount_remarks', 'payment.payment_status' ])
                    ->from('payment')
                    ->join('LEFT JOIN', 'invoice', 'payment.invoice_id = invoice.id')
                    ->join('LEFT JOIN', 'payment_type', 'payment.payment_type = payment_type.id')
                    ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                    ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                    ->join('LEFT JOIN', 'car_information', 'payment.customer_id = car_information.id')
                    ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                    ->where([ 'payment.invoice_id' => $invoiceId ])
                    ->andWhere([ 'payment.invoice_no' => $invoiceNo ])
                    ->orderBy(['payment.id' => SORT_DESC])
                    ->all();
        
        return $result;
    }

    // getPaidMultipleInvoiceById
    public function getPaidMultipleInvoiceById($invoiceId,$invoiceNo) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'car_information.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'car_information.make', 'car_information.model', 'car_information.points', 'payment.remarks as paymentRemarks', 'invoice.created_at', 'payment_type.name as paymenttypeName', 'invoice.time_created', 'invoice.gst', 'invoice.net', 'invoice.mileage', 'payment.net_with_interest', 'invoice.paid', 'invoice.updated_by', 'invoice.delete', 'invoice.time_created', 'invoice.come_in', 'invoice.come_out', 'customer.type', 'customer.company_name', 'customer.uen_no', 'customer.nric', 'car_information.engine_no', 'car_information.chasis', 'car_information.year_mfg', 'invoice.discount_amount', 'invoice.discount_remarks', 'payment.payment_status' ])
                ->from('payment')
                ->join('LEFT JOIN', 'invoice', 'payment.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'payment_type', 'payment.payment_type = payment_type.id')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                ->join('LEFT JOIN', 'car_information', 'payment.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where([ 'payment.invoice_id' => $invoiceId ])
                ->andWhere([ 'invoice.invoice_no' => $invoiceNo ])
                ->orderBy(['payment.id' => SORT_DESC])
                ->all();
        
        return $result;
    }

    // getNotPaidInvoiceById
    public function getNotPaidInvoiceById($invoiceId,$invoiceNo) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.quotation_code', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'car_information.carplate', 'customer.race_id', 'race.name as raceName', 'customer.email', 'car_information.make', 'car_information.model', 'car_information.points', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'invoice.customer_id', 'invoice.user_id', 'invoice.branch_id', 'invoice.date_issue', 'invoice.remarks', 'invoice.grand_total', 'invoice.gst', 'invoice.net', 'invoice.mileage', 'invoice.task', 'invoice.paid', 'invoice.paid_type', 'invoice.created_at', 'invoice.created_by', 'invoice.updated_at', 'invoice.updated_by', 'invoice.delete', 'invoice.time_created', 'invoice.come_in', 'invoice.come_out', 'customer.type', 'customer.company_name', 'customer.uen_no', 'customer.nric', 'car_information.engine_no', 'car_information.chasis', 'car_information.year_mfg', 'invoice.discount_amount', 'invoice.discount_remarks'])
                ->from('invoice')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
                ->where(['invoice.id' => $invoiceId])
                ->andWhere(['invoice.invoice_no' => $invoiceNo])
                ->all();
        
        return $result;
    }

    // getInvoiceServiceDetail
    public function getInvoiceServiceDetail($invoiceId) 
    {
        $rows = new Query();

        $service = InvoiceDetail::find()->where(['invoice_id' => $invoiceId, 'type' => 0])->all();

        return $service;
    }

    // getInvoicePartDetail
    public function getInvoicePartDetail($invoiceId) 
    {
        $rows = new Query();

        $part = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'product.id as productId', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal'])
            ->from('invoice_detail')
            ->join('LEFT JOIN', 'product', 'invoice_detail.service_part_id = product.id')
            ->where(['invoice_detail.invoice_id' => $invoiceId, 'invoice_detail.type' => 1])
            ->all();

        return $part;
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
    public function getPaidInvoice($invoiceId,$invoiceNo,$customerId) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'car_information.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'car_information.make', 'car_information.model', 'car_information.points', 'payment.remarks as paymentRemarks', 'invoice.created_at', 'payment_type.name as paymenttypeName', 'invoice.time_created', 'invoice.gst', 'invoice.net', 'invoice.mileage', 'payment.net_with_interest', 'customer.type', 'invoice.updated_by', 'invoice.delete', 'invoice.come_in', 'invoice.come_out', 'customer.email', 'customer.company_name', 'customer.uen_no', 'customer.nric', 'car_information.engine_no', 'car_information.chasis', 'car_information.year_mfg', 'invoice.discount_amount', 'invoice.discount_remarks', 'payment.payment_status' ])
                    ->from('payment')
                    ->join('LEFT JOIN', 'invoice', 'payment.invoice_id = invoice.id')
                    ->join('LEFT JOIN', 'payment_type', 'payment.payment_type = payment_type.id')
                    ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                    ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                    ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                    ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                    ->where([ 'payment.invoice_id' => $invoiceId ])
                    ->andWhere([ 'payment.invoice_no' => $invoiceNo ])
                    ->andWhere([ 'payment.customer_id' => $customerId ])
                    ->orderBy(['payment.id' => SORT_DESC])
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
    public function getPaidMultipleInvoice($invoiceId,$invoiceNo,$customerId) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'car_information.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'car_information.make', 'car_information.model', 'car_information.points', 'payment.remarks as paymentRemarks', 'invoice.created_at', 'payment_type.name as paymenttypeName', 'invoice.time_created', 'invoice.gst', 'invoice.net', 'invoice.mileage', 'payment.net_with_interest', 'customer.type', 'invoice.updated_by', 'invoice.delete', 'invoice.come_in', 'invoice.come_out', 'customer.email', 'customer.company_name', 'customer.uen_no', 'customer.nric', 'car_information.engine_no', 'car_information.chasis', 'car_information.year_mfg', 'invoice.discount_amount', 'invoice.discount_remarks', 'payment.payment_status' ])
                ->from('payment')
                ->join('LEFT JOIN', 'invoice', 'payment.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'payment_type', 'payment.payment_type = payment_type.id')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where([ 'payment.invoice_id' => $invoiceId ])
                ->andWhere([ 'payment.invoice_no' => $invoiceNo ])
                ->andWhere([ 'payment.customer_id' => $customerId ])
                ->orderBy(['payment.id' => SORT_DESC])
                ->all();
        
        return $result;
    }

    // get Invoice for Customer
    public function getInvoiceForCustomer($id) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'car_information.carplate', 'branch.code', 'branch.name', 'invoice.paid', 'invoice.date_issue', 'invoice.task', 'invoice.status'])
            ->from('invoice')
            ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
            ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->where(['invoice.customer_id' => $id])
            ->andWhere('invoice.delete = 0')
            ->all();

        return $result;
    }

    // getInvoiceByDateRange for Customer
    public function getInvoiceByDateRangeForCustomer($id,$date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'car_information.carplate', 'branch.code', 'branch.name', 'invoice.paid', 'invoice.date_issue', 'invoice.task'])
            ->from('invoice')
            ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
            ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->where(['invoice.customer_id' => $id])
            ->andWhere("invoice.date_issue >= '$date_start'")
            ->andWhere("invoice.date_issue <= '$date_end'")
            ->andWhere('invoice.delete = 0')
            ->all();

        return $result;
    }

    // get Invoice for Notification
    public function getInvoiceForNotification($id) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'car_information.carplate', 'branch.code', 'branch.name', 'invoice.paid', 'invoice.date_issue', 'invoice.task', 'invoice.status', 'user.photo'])
            ->from('invoice')
            ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
            ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->where(['invoice.customer_id' => $id])
            ->andWhere('invoice.paid = 0')
            ->andWhere('invoice.status = 0')
            ->all();

        return $result;
    }

    // get product by category
    public function getPartsByCategory($id)
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'supplier.supplier_name', 'product.product_name', 'inventory.quantity', 'inventory.selling_price'])
            ->from('inventory')
            ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
            ->join('LEFT JOIN', 'category', 'product.category_id = category.id')
            ->join('LEFT JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->where(['product.category_id' => $id])
            ->all();

        return $result;
    }

    // get service by category
    public function getServicesByCategory($id)
    {
        $rows = new Query();

        $result = $rows->select(['service.id', 'service_category.name', 'service.service_name', 'service.default_price'])
            ->from('service')
            ->join('LEFT JOIN', 'service_category', 'service.service_category_id = service_category.id')
            ->where(['service.service_category_id' => $id])
            ->all();

        return $result;
    }

    // get invoice payment information 
    public function getInvoicePaymentInformation($id)
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'car_information.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'car_information.make', 'car_information.model', 'car_information.points', 'payment.remarks as paymentRemarks','payment.interest', 'invoice.invoice_no as multipleInvoiceNo', 'invoice.created_at', 'payment_type.name as paymenttypeName', 'invoice.time_created', 'invoice.gst', 'invoice.net', 'invoice.mileage', 'payment_type.name as paymentTypeName', 'payment.net_with_interest', 'invoice.payment_status' ])
                ->from('payment')
                ->join('LEFT JOIN', 'invoice', 'payment.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'payment_type', 'payment.payment_type = payment_type.id')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where([ 'payment.invoice_id' => $id ])
                ->all();
        
        return $result;
    }

    // get invoice with outstading payments
    public function getInvoiceWithOutstandingPayments()
    {
        $rows = new Query();

        $result = $rows->select([ 'invoice.*', 'customer.fullname', 'user.fullname as salesPerson', 'branch.name as branchName', 'customer.type', 'customer.company_name' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
                ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
                ->where('invoice.paid <> 1')
                ->orderBy(['invoice.id' => SORT_DESC])
                ->all();
        
        return $result;
    }

    // get Not Paid Invoice
    public function getOutstandingPaymentInvoice($invoiceId) 
    {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'car_information.carplate', 'car_information.points', 'customer.race_id', 'race.name as raceName', 'customer.email', 'car_information.make', 'car_information.model', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'invoice.date_issue', 'invoice.remarks', 'invoice.grand_total', 'invoice.gst', 'invoice.net', 'invoice.mileage', 'invoice.task', 'invoice.status', 'invoice.paid_type', 'invoice.time_created', 'invoice.paid', 'invoice.balance_amount', 'invoice.come_in', 'invoice.come_out', 'customer.type', 'customer.company_name', 'customer.uen_no', 'customer.nric', 'car_information.engine_no', 'car_information.chasis', 'car_information.year_mfg', 'invoice.discount_amount', 'invoice.discount_remarks', 'invoice.branch_id', 'invoice.user_id', 'invoice.customer_id', 'invoice.quotation_code' ])
            ->from('invoice')
            ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
            ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->join('LEFT JOIN', 'car_information', 'invoice.customer_id = car_information.id')
            ->join('LEFT JOIN', 'customer', 'car_information.customer_id = customer.id')
            ->join('LEFT JOIN', 'race', 'customer.race_id = race.id')
            ->where(['invoice.id' => $invoiceId])
            ->andWhere('invoice.paid <> 1')
            ->one();

        return $result;
    }

}
