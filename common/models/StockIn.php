<?php

namespace common\models;

use Yii;

use yii\db\Query;
/**
 * This is the model class for table "stock_in".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $supplier_id
 * @property integer $quantity
 * @property double $cost_price
 * @property double $selling_price
 * @property string $date_imported
 * @property string $created_at
 * @property integer $created_by
 */
class StockIn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock_in';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'supplier_id', 'quantity', 'cost_price', 'selling_price', 'date_imported', 'created_at', 'created_by'], 'required'],
            [['product_id', 'supplier_id', 'quantity', 'created_by'], 'integer'],
            [['cost_price', 'selling_price'], 'number'],
            [['date_imported', 'created_at'], 'safe'],
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
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

}
