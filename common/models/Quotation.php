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
