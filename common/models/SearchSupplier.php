<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Supplier;
use yii\db\Query;

/**
 * SearchSupplier represents the model behind the search form about `common\models\Supplier`.
 */
class SearchSupplier extends Supplier
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'contact_number'], 'integer'],
            [['supplier_code', 'supplier_name', 'address', 'contact_number'], 'safe'],
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
        $query = Supplier::find();

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
        ]);

        $query->andFilterWhere(['like', 'supplier_code', $this->supplier_code])
            ->andFilterWhere(['like', 'supplier_name', $this->supplier_name]);

        return $dataProvider;
    }

    public function searchSupplier($supplier_code,$supplier_name) {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('supplier')
                    ->where(['like', 'supplier_code', $supplier_code])
                    ->orWhere(['like', 'supplier_name', $supplier_name])
                    ->all();

        return $result;  
    }
}
