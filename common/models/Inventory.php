<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "inventory".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $supplier_id
 * @property integer $quantity
 * @property double $cost_price
 * @property double $selling_price
 * @property string $date_imported
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 */
class Inventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // date_imported', 'status', 'created_at', 'created_by'
            [['product_id', 'supplier_id', 'quantity', 'cost_price', 'selling_price'], 'required'],
            [['product_id', 'supplier_id', 'quantity'], 'integer'],
            // [['cost_price', 'selling_price'], 'number'],
            // [['date_imported', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'supplier_id' => 'Supplier ID',
            'quantity' => 'Quantity',
            'cost_price' => 'Cost Price',
            'selling_price' => 'Selling Price',
            'date_imported' => 'Date Imported',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

}
