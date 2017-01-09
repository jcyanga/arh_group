<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;
use yii\db\Query;

/**
 * SearchProduct represents the model behind the search form about `common\models\Product`.
 */
class SearchProduct extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'category_id', 'created_by'], 'integer'],
            [['product_code', 'product_name', 'product_image', 'unit_of_measure', 'created_at'], 'safe'],
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
        $query = Product::find();

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
            'status' => $this->status,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'product_code', $this->product_code])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_image', $this->product_image])
            ->andFilterWhere(['like', 'unit_of_measure', $this->unit_of_measure]);

        return $dataProvider;
    }

    public function searchForIndex($params)
    {   
        $rows = new Query();

        $query = Product::find();
        // $query = $rows->select(['product.id', 'category.category', 'product.product_code', 'product.product_name', 'product.unit_of_measure', 'product.category_id', 'product.product_image', 'product.status', 'product.created_at', 'product.created_by'])
        //     ->from('product')
        //     ->join('INNER JOIN', 'category', 'product.category_id = category.id')
        //     ->all();

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
            'status' => $this->status,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'product_code', $this->product_code])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'product_image', $this->product_image])
            ->andFilterWhere(['like', 'unit_of_measure', $this->unit_of_measure]);

        return $query;
    }

    public function searchProduct($category_id,$product_name) {
        $rows = new Query();

        $result = $rows->select(['product.id', 'category.category', 'product.product_code', 'product.product_name', 'product.unit_of_measure', 'product.category_id', 'product.product_image', 'product.status', 'product.created_at', 'product.created_by'])
            ->from('product')
            ->join('INNER JOIN', 'category', 'product.category_id = category.id')
            ->where(['product.category_id' => $category_id])
            ->orWhere(['product.product_name' => $product_name])
            ->all();

        return $result;            
    }

}
