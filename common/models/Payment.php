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

}
