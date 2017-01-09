<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Service;
use yii\db\Query;

/**
 * SearchService represents the model behind the search form about `common\models\Service`.
 */
class SearchService extends Service
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'service_category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['service_name', 'description', 'created_at', 'updated_at'], 'safe'],
            [['default_price'], 'number'],
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
        $query = Service::find();

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
            'service_category_id' => $this->service_category_id,
            'default_price' => $this->default_price,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'service_name', $this->service_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    public function searchService($service_category_id,$service_name) {
        $rows = new Query();

        $result = $rows->select(['service.id','service.service_category_id','service_category.name','service.service_name','service.description','service.default_price','service.status','service.created_at','service.created_by'])
            ->from('service')
            ->join('INNER JOIN', 'service_category', 'service.service_category_id = service_category.id')
            ->where(['like', 'service.service_category_id', $service_category_id])
            ->orWhere(['like', 'service.service_name', $service_name])
            ->all();

        return $result;  
    }
}
