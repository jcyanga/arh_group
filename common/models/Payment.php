<?php

namespace common\models;

use Yii;

use yii\db\Query;
/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $invoice_id
 * @property double $amount
 * @property double $discount
 * @property integer $payment_method
 * @property string $payment_type
 * @property integer $points_earned
 * @property integer $points_redeem
 * @property string $remarks
 * @property string $payment_date
 * @property string $payment_time
 * @property integer $status
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'amount', 'discount', 'payment_method', 'payment_type', 'points_earned', 'points_redeem', 'remarks', 'payment_date', 'payment_time', 'status'], 'required'],
            [['invoice_id', 'payment_method', 'points_earned', 'points_redeem', 'status'], 'integer'],
            [['amount', 'discount'], 'number'],
            [['remarks'], 'string'],
            [['payment_date', 'payment_time'], 'safe'],
            [['payment_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Invoice ID',
            'amount' => 'Amount',
            'discount' => 'Discount',
            'payment_method' => 'Payment Method',
            'payment_type' => 'Payment Type',
            'points_earned' => 'Points Earned',
            'points_redeem' => 'Points Redeem',
            'remarks' => 'Remarks',
            'payment_date' => 'Payment Date',
            'payment_time' => 'Payment Time',
            'status' => 'Status',
        ];
    }

    // checkInvoiceIfExist
    public function checkInvoice($invoiceId,$invoiceNo,$customerId) {
        $rows = new Query();

        $result = Payment::find()->where(['invoice_id' => $invoiceId])->andWhere(['invoice_no' => $invoiceNo])->andWhere(['customer_id' => $customerId])->all();
        
        if( count($result) > 0 ) {
            return $result;
        }else{
            return 0;
        }

    }

    // checkMultipleInvoiceIfExist
    public function checkMultipleInvoice($mInvoiceId,$invoiceNo,$mCustomerId) {
        $rows = new Query();

        $result = Payment::find()->where(['invoice_id' => $mInvoiceId])->andWhere(['invoice_no' => $invoiceNo])->andWhere(['customer_id' => $mCustomerId])->all();
        
        if( count($result) > 0 ) {
            return $result;
        }else{
            return 0;
        }

    }

    // getPaidInvoice
    public function getInvoice($lastId,$invoiceId,$invoiceNo,$customerId) {
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

    // getInvoiceServiceDetail
    public function getInvoiceServiceDetail($invoiceId) {
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
    public function getInvoicePartDetail($invoiceId) {
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

    // getPaidMultipleInvoice
    public function getMultipleInvoice($getId,$invoiceId,$invoiceNo,$customerId) {
        $rows = new Query();

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.discount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'customer.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'payment.remarks as paymentRemarks' ])
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

    // getPaidInvoiceById
    public function getInvoiceById($invoiceId,$invoiceNo) {
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

    // getMultipleInvoiceById
    public function getMultipleInvoiceById($invoiceId,$invoiceNo) {
        $rows = new Query();

        $result = $rows->select([ 'payment.id', 'payment.invoice_id', 'payment.invoice_no', 'payment.customer_id', 'payment.amount', 'payment.discount', 'payment.payment_method', 'payment.payment_type', 'payment.points_earned', 'payment.points_redeem', 'payment.remarks', 'payment.payment_date', 'payment.payment_time', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'invoice.user_id', 'branch.name', 'branch.address', 'branch.contact_no as branchNumber', 'user.fullname as salesPerson', 'invoice.branch_id', 'customer.fullname', 'customer.carplate', 'customer.hanphone_no', 'customer.office_no', 'customer.address as customerAddress', 'payment.remarks as paymentRemarks' ])
                ->from('payment')
                ->join('LEFT JOIN', 'invoice', 'payment.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'user', 'invoice.user_id = user.id')
                ->join('LEFT JOIN', 'branch', 'invoice.branch_id = branch.id')
                ->join('LEFT JOIN', 'customer', 'payment.customer_id = customer.id')
                ->where([ 'payment.invoice_id' => $invoiceId ])
                ->andWhere([ 'payment.invoice_no' => $invoiceNo ])
                ->all();
        
        return $result;
    
    }

}
