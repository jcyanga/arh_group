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

    // getMonthlyStockReport
    public function getMonthlyStock() {
        $rows = new Query();

        $result = $rows->select([ 'stock_in.id', 'stock_in.product_id', 'product.product_code', 'product.product_name', 'stock_in.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'stock_in.quantity', 'stock_in.cost_price', 'stock_in.selling_price', 'stock_in.date_imported', 'stock_in.created_by', 'user.fullname' ])
                ->from('stock_in')
                ->join('LEFT JOIN', 'product', 'stock_in.product_id = product.id')
                ->join('LEFT JOIN', 'supplier', 'stock_in.supplier_id = supplier.id')
                ->join('LEFT JOIN', 'user', 'stock_in.created_by = user.id')
                ->groupBy('stock_in.product_id')
                ->all();

        return $result;
    }

    // getMonthlyStockReportByDateRange
    public function getMonthlyStockByDateRange($date_start,$date_end) {
        $rows = new Query();

        $result = $rows->select([ 'stock_in.id', 'stock_in.product_id', 'product.product_code', 'product.product_name', 'stock_in.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'stock_in.quantity', 'stock_in.cost_price', 'stock_in.selling_price', 'stock_in.date_imported', 'stock_in.created_by', 'user.fullname' ])
                ->from('stock_in')
                ->join('LEFT JOIN', 'product', 'stock_in.product_id = product.id')
                ->join('LEFT JOIN', 'supplier', 'stock_in.supplier_id = supplier.id')
                ->join('LEFT JOIN', 'user', 'stock_in.created_by = user.id')
                ->where("stock_in.date_imported >= '$date_start'")
                ->andWhere("stock_in.date_imported <= '$date_end'")
                ->groupBy('stock_in.product_id')
                ->all();

        return $result;
    }
}
