<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ServiceCategory;
use yii\db\Query;

/**
 * SearchServiceCategory represents the model behind the search form about `common\models\ServiceCategory`.
 */
class SearchServiceCategory extends ServiceCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = ServiceCategory::find();

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
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    // Search box result
    public function searchServiceCategoryName($name) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('service_category')
                    ->where(['like', 'name', $name])
                    ->all();

        return $result;  
    }

    // Search if with same name.
    public function getServiceCategories($name) 
    {
           $rows = new Query();
        
           $result = $rows->select(['name'])
            ->from('service_category')
            ->where(['name' => $name])
            ->all();
            
            if( count($result) > 0 ) {
                return TRUE;
            }else {
                return 0;
            }
    }
}
