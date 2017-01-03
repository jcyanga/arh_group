<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\QuotationSubtotal;

/**
 * SearchQuotationSubtotal represents the model behind the search form about `common\models\QuotationSubtotal`.
 */
class SearchQuotationSubtotal extends QuotationSubtotal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quotation_id', 'item_id', 'qty', 'type', 'created_by'], 'integer'],
            [['price', 'subTotal'], 'number'],
            [['created_at'], 'safe'],
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
        $query = QuotationSubtotal::find();

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
            'quotation_id' => $this->quotation_id,
            'item_id' => $this->item_id,
            'qty' => $this->qty,
            'price' => $this->price,
            'subTotal' => $this->subTotal,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ]);

        return $dataProvider;
    }
}
