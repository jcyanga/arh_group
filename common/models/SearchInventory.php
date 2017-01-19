<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Inventory;

use yii\db\Query;
/**
 * SearchInventory represents the model behind the search form about `common\models\Inventory`.
 */
class SearchInventory extends Inventory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'supplier_id', 'quantity', 'status', 'created_by'], 'integer'],
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
        $query = Inventory::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        return $dataProvider;
    }

    // get Product List
    public function getProductInInventory() 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.product_id', 'product.product_code', 'product.product_name', 'inventory.quantity', 'inventory.cost_price', 'inventory.selling_price', 'inventory.date_imported'])
            ->from('inventory')
            ->join('INNER JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
            ->orderBy('inventory.id')
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }   
    }

    // get Supplier Name and Product Name
    public function selectSupplierNameandProductName($supplier_id,$product_id) 
    {
        $rows = new Query();

        $result = $rows->select(['supplier_id', 'product_id'])
            ->from('inventory')
            ->where(['supplier_id' => $supplier_id])
            ->andWhere(['product_id' => $product_id])
            ->all();

        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }

    // get Product by Id
    public function getProductInInventoryById($id) 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.product_id', 'product.product_code', 'product.product_name', 'inventory.quantity', 'inventory.cost_price', 'inventory.selling_price','inventory.date_imported','inventory.created_at','inventory.status'])
            ->from('inventory')
            ->join('INNER JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
            ->where(['inventory.id' => $id])
            ->orderBy('inventory.id')
            ->one();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        }   
    }

    // get zero product stock
    public function getZeroStock() 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.product_id', 'product.product_code', 'product.product_name', 'inventory.quantity', 'inventory.cost_price', 'inventory.selling_price','inventory.date_imported','inventory.created_at'])
            ->from('inventory')
            ->join('INNER JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
            ->where('inventory.quantity = 0')
            ->orderBy('product.product_name')
            ->limit(10)
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get zero product stock
    public function getTotalZeroStock() 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.product_id', 'product.product_code', 'product.product_name', 'inventory.quantity', 'inventory.cost_price', 'inventory.selling_price','inventory.date_imported','inventory.created_at'])
            ->from('inventory')
            ->join('INNER JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
            ->where('inventory.quantity = 0')
            ->orderBy('product.product_name')
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get critical product stock
    public function getCriticalStock($criticalLevel) 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.product_id', 'product.product_code', 'product.product_name', 'inventory.quantity', 'inventory.cost_price', 'inventory.selling_price','inventory.date_imported','inventory.created_at'])
            ->from('inventory')
            ->join('INNER JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
            ->where("inventory.quantity <= $criticalLevel")
            ->orderBy('product.product_name')
            ->limit(10)
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get total critical product stock
    public function getTotalCriticalStock($criticalLevel) 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.product_id', 'product.product_code', 'product.product_name', 'inventory.quantity', 'inventory.cost_price', 'inventory.selling_price','inventory.date_imported','inventory.created_at'])
            ->from('inventory')
            ->join('INNER JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
            ->where("inventory.quantity <= $criticalLevel")
            ->orderBy('product.product_name')
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get warning product stock
    public function getWarningStock($minimumLevel) 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.product_id', 'product.product_code', 'product.product_name', 'inventory.quantity', 'inventory.cost_price', 'inventory.selling_price','inventory.date_imported','inventory.created_at'])
            ->from('inventory')
            ->join('INNER JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
            ->where("inventory.quantity <= $minimumLevel")
            ->orderBy('product.product_name')
            ->limit(10)
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

    // get total warning product stock
    public function getTotalWarningStock($minimumLevel) 
    {
        $rows = new Query();

        $result = $rows->select(['inventory.id', 'inventory.supplier_id', 'supplier.supplier_code', 'supplier.supplier_name', 'inventory.product_id', 'product.product_code', 'product.product_name', 'inventory.quantity', 'inventory.cost_price', 'inventory.selling_price','inventory.date_imported','inventory.created_at'])
            ->from('inventory')
            ->join('INNER JOIN', 'supplier', 'inventory.supplier_id = supplier.id')
            ->join('INNER JOIN', 'product', 'inventory.product_id = product.id')
            ->where("inventory.quantity <= $minimumLevel")
            ->orderBy('product.product_name')
            ->all();

        if( count($result) > 0 ) {
            return $result;
        }else {
            return 0;
        } 
    }

}
