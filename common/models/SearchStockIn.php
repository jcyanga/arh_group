<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StockIn;

use yii\db\Query;
/**
 * SearchStockIn represents the model behind the search form about `common\models\StockIn`.
 */
class SearchStockIn extends StockIn
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'supplier_id', 'quantity', 'created_by'], 'integer'],
            [['cost_price', 'selling_price'], 'number'],
            [['date_imported', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StockIn::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'supplier_id' => $this->supplier_id,
            'quantity' => $this->quantity,
            'cost_price' => $this->cost_price,
            'selling_price' => $this->selling_price,
            'date_imported' => $this->date_imported,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        return $dataProvider;
    }

    // getMonthlyStockReport
    public function getMonthlyStock() 
    {
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
    public function getMonthlyStockByDateRange($date_start,$date_end) 
    {
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

    // getMonthlySalesReport
    public function getMonthlySales() 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id as paymentId', 'payment.invoice_id as invoiceId', 'invoice.invoice_no', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'payment.amount', 'payment.discount', 'payment.payment_method', 'payment.payment_type', 'payment.remarks', 'payment.payment_date' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'payment', 'invoice.id = payment.invoice_id')
                ->join('LEFT JOIN', 'customer', 'invoice.customer_id = customer.id')
                ->where('invoice.status = 1')
                ->groupBy('invoice_no')
                ->orderBy('date_issue', 'desc')
                ->all();

        return $result;
    }

    // getMonthlySalesReportByDateRange
    public function getMonthlySalesReportByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select([ 'payment.id as paymentId', 'payment.invoice_id as invoiceId', 'invoice.invoice_no', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.grand_total', 'invoice.date_issue', 'invoice.remarks', 'payment.amount', 'payment.discount', 'payment.payment_method', 'payment.payment_type', 'payment.remarks', 'payment.payment_date' ])
                ->from('invoice')
                ->join('LEFT JOIN', 'payment', 'invoice.id = payment.invoice_id')
                ->join('LEFT JOIN', 'customer', 'invoice.customer_id = customer.id')
                ->where('invoice.status = 1')
                ->andWhere("invoice.date_issue >= '$date_start'")
                ->andWhere("invoice.date_issue <= '$date_end'")
                ->groupBy('invoice_no')
                ->orderBy('date_issue', 'desc')
                ->all();

        return $result;
    }

    // getBestSellingService
    public function getBestSellingService() 
    {
        $rows = new Query();

        $result = $rows->select([ 'invoice_detail.id as invoiceDetailId', 'invoice_detail.invoice_id', 'invoice.invoice_no', 'invoice_detail.service_part_id', 'service_category.name', 'service.service_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal' ])
                ->from('invoice_detail')
                ->join('LEFT JOIN', 'invoice', 'invoice_detail.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'service', 'invoice_detail.service_part_id = service.id')
                ->join('LEFT JOIN', 'service_category', 'service.service_category_id = service_category.id')
                ->where('invoice_detail.type = 0')
                ->andWhere('invoice_detail.status = 1')
                ->orderBy('subTotal', 'asc')
                ->all();

        return $result;
    }

    // getBestSellingParts
    public function getBestSellingParts() 
    {
        $rows = new Query();

        $result = $rows->select([ 'invoice_detail.id as invoiceDetailId', 'invoice_detail.invoice_id', 'invoice.invoice_no', 'invoice_detail.service_part_id', 'category.category', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal' ])
                ->from('invoice_detail')
                ->join('LEFT JOIN', 'invoice', 'invoice_detail.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'inventory', 'invoice_detail.service_part_id = inventory.id')
                ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
                ->join('LEFT JOIN', 'category', 'product.category_id = category.id')
                ->where('invoice_detail.type = 1')
                ->andWhere('invoice_detail.status = 1')
                ->orderBy('subTotal', 'asc')
                ->all();

        return $result;
    }

    // getBestSellingServicesReportByDateRange
    public function getBestSellingServicesReportByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select([ 'invoice_detail.id as invoiceDetailId', 'invoice_detail.invoice_id', 'invoice.invoice_no', 'invoice_detail.service_part_id', 'service_category.name', 'service.service_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal' ])
                ->from('invoice_detail')
                ->join('LEFT JOIN', 'invoice', 'invoice_detail.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'service', 'invoice_detail.service_part_id = service.id')
                ->join('LEFT JOIN', 'service_category', 'service.service_category_id = service_category.id')
                ->where('invoice_detail.type = 0')
                ->andWhere('invoice_detail.status = 1')
                ->andWhere("invoice.date_issue >= '$date_start'")
                ->andWhere("invoice.date_issue <= '$date_end'")
                ->orderBy('subTotal', 'asc')
                ->all();

        return $result;
    }

    // getBestSellingPartsReportByDateRange
    public function getBestSellingPartsReportByDateRange($date_start,$date_end) 
    {
        $rows = new Query();

        $result = $rows->select([ 'invoice_detail.id as invoiceDetailId', 'invoice_detail.invoice_id', 'invoice.invoice_no', 'invoice_detail.service_part_id', 'category.category', 'product.product_name', 'invoice_detail.quantity', 'invoice_detail.selling_price', 'invoice_detail.subTotal' ])
                ->from('invoice_detail')
                ->join('LEFT JOIN', 'invoice', 'invoice_detail.invoice_id = invoice.id')
                ->join('LEFT JOIN', 'inventory', 'invoice_detail.service_part_id = inventory.id')
                ->join('LEFT JOIN', 'product', 'inventory.product_id = product.id')
                ->join('LEFT JOIN', 'category', 'product.category_id = category.id')
                ->where('invoice_detail.type = 1')
                ->andWhere('invoice_detail.status = 1')
                ->andWhere("invoice.date_issue >= '$date_start'")
                ->andWhere("invoice.date_issue <= '$date_end'")
                ->orderBy('subTotal', 'asc')
                ->all();

        return $result;
    }
  
}
