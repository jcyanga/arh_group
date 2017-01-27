<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Staff;

use yii\db\Query;
/**
 * SearchStaff represents the model behind the search form about `common\models\Staff`.
 */
class SearchStaff extends Staff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['staff_code', 'fullname', 'created_at', 'updated_at'], 'safe'],
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
        $query = Staff::find();

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

        $query->andFilterWhere(['like', 'staff_code', $this->staff_code])
            ->andFilterWhere(['like', 'fullname', $this->fullname]);

        return $dataProvider;
    }

     // Search box result.
    public function searchStaffName($name) 
    {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('staff')
                    ->where(['like', 'fullname', $name])
                    ->all();

        return $result;  
    }

    // Search if with same name.
    public function getStaff($name) 
    {
       $rows = new Query();
    
       $result = $rows->select(['fullname'])
        ->from('staff')
        ->where(['fullname' => $name])
        ->all();
        
        if( count($result) > 0 ) {
            return TRUE;
        }else {
            return 0;
        }
    }
}
