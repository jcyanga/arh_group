<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TermsAndConditions;

use yii\db\Query;
/**
 * SearchTermsAndConditions represents the model behind the search form about `common\models\TermsAndConditions`.
 */
class SearchTermsAndConditions extends TermsAndConditions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['descriptions', 'created_at', 'updated_at'], 'safe'],
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
        $query = TermsAndConditions::find();

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
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'descriptions', $this->descriptions]);

        return $dataProvider;
    }

    // Search box result.
    public function searchTermsConditions($desc) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('terms_and_conditions')
                    ->where(['like', 'descriptions', $desc])
                    ->all();

        return $result;  
    }

    // Search if with same descriptions.
    public function getTermsAndConditions($desc) 
    {
       $rows = new Query();
    
       $result = $rows->select(['descriptions'])
        ->from('terms_and_conditions')
        ->where(['descriptions' => $desc])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }
}
