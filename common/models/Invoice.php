<?php

namespace common\models;

use Yii;

use yii\db\Query;
/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property string $invoice_no
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $branch_id
 * @property string $date_issue
 * @property double $grand_total
 * @property string $remarks
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $delete
 * @property integer $task
 * @property integer $paid
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_no', 'user_id', 'customer_id', 'branch_id', 'date_issue', 'grand_total', 'remarks', 'created_at', 'created_by', 'updated_at', 'updated_by', 'delete', 'task', 'paid'], 'required'],
            [['user_id', 'customer_id', 'branch_id', 'created_by', 'updated_by', 'delete', 'task', 'paid'], 'integer'],
            [['date_issue', 'created_at', 'updated_at'], 'safe'],
            [['grand_total'], 'number'],
            [['remarks'], 'string'],
            [['invoice_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_no' => 'Invoice No',
            'user_id' => 'User ID',
            'customer_id' => 'Customer ID',
            'branch_id' => 'Branch ID',
            'date_issue' => 'Date Issue',
            'grand_total' => 'Grand Total',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'delete' => 'Delete',
            'task' => 'Task',
            'paid' => 'Paid',
        ];
    }

    // get id
    public function getInvoiceId() {
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

    // get branch
    public function getBranch() {
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
    public function getUser() {
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
    public function getCustomer() {
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
    public function getServicesList() {
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
    public function getPartsList() {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.product_id as productId', 'product.product_name', 'category.category', 'supplier.supplier_name'])
        ->from('inventory')
        ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
        ->join('LEFT JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
        ->join('LEFT JOIN', 'category', 'product.category_id = category.id')
        ->all();

        if( count($result) > 0 ) {
            return $result;
        
        }else {
            return 0;
        
        }   

    }

    // get part info
    public function getPartInfo($ItemId) {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.product_id', 'product.product_name'])
        ->from('inventory')
        ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
        ->where(['inventory.id' => $ItemId])
        ->one();

        return $result;

    }

    // getLastInsertInvoice
    public function getLastInsertInvoice($invoiceId) {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'customer.carplate', 'customer.race', 'customer.email', 'customer.make', 'customer.model', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'invoice.date_issue', 'invoice.remarks', 'invoice.grand_total', 'invoice.task', 'invoice.status'])
            ->from('invoice')
            ->join('INNER JOIN', 'user', 'invoice.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'invoice.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'invoice.branch_id = branch.id')
            ->where(['invoice.id' => $invoiceId])
            ->one();

        return $result;
    }

    // getLastInsertInvoiceServiceDetail
    public function getLastInsertInvoiceServiceDetail($id) {
        $rows = new Query();

        $service = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'service.service_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal', 'invoice_detail.task'])
            ->from('invoice_detail')
            ->join('INNER JOIN', 'service', 'invoice_detail.service_part_id = service.id')
            ->where(['invoice_detail.invoice_id' => $id])
            ->andWhere('invoice_detail.type = 0')
            ->all();

        return $service;
    }

    // getLastInsertInvoicePartDetail
    public function getLastInsertInvoicePartDetail($id) {
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

    // getInvoice
    public function getInvoice($invoiceId) {
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

    // getInvoiceServiceDetail
    public function getInvoiceServiceDetail($id) {
        $rows = new Query();

        $service = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'service.id as serviceId', 'service.service_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal', 'invoice_detail.task'])
            ->from('invoice_detail')
            ->join('INNER JOIN', 'service', 'invoice_detail.service_part_id = service.id')
            ->where(['invoice_detail.invoice_id' => $id])
            ->andWhere('invoice_detail.type = 0')
            ->all();

        return $service;
    }

    // getInvoicePartDetail
    public function getInvoicePartDetail($id) {
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
    public function getLastId($id) {
        $rows= new Query();

        $lastId = $rows->select(['max(id) as id'])
                    ->from('invoice_detail')
                    ->where(['invoice_id' => $id ])
                    ->one();

        return $lastId['id'];
    }
}
