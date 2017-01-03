<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quotation_subtotal".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property integer $item_id
 * @property integer $qty
 * @property double $price
 * @property double $subTotal
 * @property integer $type
 * @property string $created_at
 * @property integer $created_by
 */
class QuotationSubtotal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_subtotal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_id', 'item_id', 'qty', 'price', 'subTotal', 'type', 'created_at', 'created_by'], 'required'],
            [['quotation_id', 'item_id', 'qty', 'type', 'created_by'], 'integer'],
            [['price', 'subTotal'], 'number'],
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
            'item_id' => 'Item ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'subTotal' => 'Sub Total',
            'type' => 'Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}
