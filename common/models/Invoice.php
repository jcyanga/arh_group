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

    // getInvoice
    public function getInvoice($invoiceId) {
        $rows = new Query();

        $result = $rows->select(['invoice.id', 'invoice.quotation_code', 'invoice.invoice_no', 'user.fullname as salesPerson', 'customer.fullname', 'customer.address as customerAddress', 'customer.hanphone_no', 'customer.office_no', 'customer.carplate', 'branch.id as BranchId', 'branch.code', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'invoice.date_issue', 'invoice.remarks', 'invoice.grand_total'])
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

        $service = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'service.service_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal', 'invoice_detail.task'])
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

        $part = $rows->select(['invoice_detail.id', 'invoice_detail.invoice_id', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal'])
            ->from('invoice_detail')
            ->join('INNER JOIN', 'product', 'invoice_detail.service_part_id = product.id')
            ->where(['invoice_detail.invoice_id' => $id])
            ->andWhere('invoice_detail.type = 1')
            ->all();

        return $part;
    }
}
