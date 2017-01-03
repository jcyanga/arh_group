<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Quotation;

/**
 * SearchQuotation represents the model behind the search form about `common\models\Quotation`.
 */
class SearchQuotation extends Quotation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'customer_id', 'branch_id', 'no_of_services', 'no_of_parts', 'created_by', 'updated_by', 'delete'], 'integer'],
            [['quotation_code', 'date_issue', 'type', 'remarks', 'created_at', 'updated_at'], 'safe'],
            [['grand_total'], 'number'],
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
        $query = Quotation::find();

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
            'user_id' => $this->user_id,
            'customer_id' => $this->customer_id,
            'branch_id' => $this->branch_id,
            'date_issue' => $this->date_issue,
            'no_of_services' => $this->no_of_services,
            'no_of_parts' => $this->no_of_parts,
            'grand_total' => $this->grand_total,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'delete' => $this->delete,
        ]);

        $query->andFilterWhere(['like', 'quotation_code', $this->quotation_code])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}