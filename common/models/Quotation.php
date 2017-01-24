<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "quotation".
 *
 * @property integer $id
 * @property string $quotation_code
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $branch_id
 * @property string $date_issue
 * @property string $type
 * @property integer $no_of_services
 * @property integer $no_of_parts
 * @property double $grand_total
 * @property string $remarks
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $delete
 */
class Quotation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_code', 'user_id', 'customer_id', 'branch_id', 'date_issue', 'grand_total', 'remarks', 'created_at', 'created_by', 'updated_at', 'updated_by', 'delete', 'invoice'], 'required'],
            [['user_id', 'customer_id', 'branch_id', 'created_by', 'updated_by', 'delete', 'invoice'], 'integer'],
            [['date_issue', 'created_at', 'updated_at'], 'safe'],
            [['grand_total'], 'number'],
            [['remarks'], 'string'],
            [['quotation_code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_code' => 'Quotation Code',
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
        ];
    }

    // get id
    public function getQuotationId() {
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

    // getLastInsertQuotation
    public function getLastInsertQuotation($quotationId) {
        $rows = new Query();

        $result = $rows->select(['quotation.id', 'quotation.quotation_code', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'customer.carplate', 'customer.race', 'customer.email', 'customer.make', 'customer.model', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'quotation.date_issue', 'quotation.remarks', 'quotation.grand_total', 'quotation.task', 'quotation.invoice'])
            ->from('quotation')
            ->join('INNER JOIN', 'user', 'quotation.user_id = user.id')
            ->join('INNER JOIN', 'customer', 'quotation.customer_id = customer.id')
            ->join('INNER JOIN', 'branch', 'quotation.branch_id = branch.id')
            ->where(['quotation.id' => $quotationId])
            ->one();

        return $result;
    }

    // getLastInsertQuotationServiceDetail
    public function getLastInsertQuotationServiceDetail($id) {
        $rows = new Query();

        $service = $rows->select(['quotation_detail.id', 'quotation_detail.quotation_id', 'service.service_name', 'quotation_detail.quantity', 'quotation_detail.selling_price', 'quotation_detail.subTotal', 'quotation_detail.task'])
            ->from('quotation_detail')
            ->join('INNER JOIN', 'service', 'quotation_detail.service_part_id = service.id')
            ->where(['quotation_detail.quotation_id' => $id])
            ->andWhere('quotation_detail.type = 0')
            ->all();

        return $service;
    }

    // getLastInsertQuotationPartDetail
    public function getLastInsertQuotationPartDetail($id) {
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

    // getQuotation
    public function getQuotation($id) {
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

    // getQuotationDetailService
    public function getQuotationDetailService($id) {
        $rows = new Query();

        $service = $rows->select(['quotation_detail.id', 'quotation_detail.quotation_id', 'service.id as serviceId', 'service.service_name', 'quotation_detail.quantity', 'quotation_detail.selling_price', 'quotation_detail.subTotal', 'quotation_detail.task', 'quotation_detail.created_at', 'quotation_detail.created_by', 'quotation_detail.type'])
            ->from('quotation_detail')
            ->join('INNER JOIN', 'service', 'quotation_detail.service_part_id = service.id')
            ->where(['quotation_detail.quotation_id' => $id])
            ->andWhere('quotation_detail.type = 0')
            ->all();

        return $service;
    }

    // getQuotationDetailPart
    public function getQuotationDetailPart($id) {
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
    public function getLastId($id) {
        $rows= new Query();

        $lastId = $rows->select(['max(id) as id'])
                    ->from('quotation_detail')
                    ->where(['quotation_id' => $id ])
                    ->one();

        return $lastId['id'];
    }

}
