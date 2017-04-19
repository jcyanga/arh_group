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
            [['invoice_no', 'date_issue', 'grand_total', 'gst', 'net', 'mileage'], 'required', 'message' => 'Fill up the required fields.'],
            [['branch_id', 'customer_id', 'user_id'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'message' => 'Invalid option selected'],
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

}
