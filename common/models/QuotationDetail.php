<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quotation_detail".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property integer $service_part_id
 * @property integer $quantity
 * @property double $selling_price
 * @property double $subTotal
 * @property string $created_at
 * @property integer $created_by
 * @property integer $type
 */
class QuotationDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_id', 'service_part_id', 'quantity', 'selling_price', 'subTotal', 'created_at', 'created_by', 'type', 'task'], 'required'],
            [['quotation_id', 'service_part_id', 'quantity', 'created_by', 'type', 'task'], 'integer'],
            [['selling_price', 'subTotal'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_id' => 'Quotation ID',
            'service_part_id' => 'Service Part ID',
            'quantity' => 'Quantity',
            'selling_price' => 'Selling Price',
            'subTotal' => 'Sub Total',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'type' => 'Type',
            'task' => 'Task',
        ];
    }
}
