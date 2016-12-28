<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

use yii\db\Query;
/**
 * SearchCustomer represents the model behind the search form about `common\models\Customer`.
 */
class SearchCustomer extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {

        
        // , 'is_blacklist', 'is_member', created_by', 'updated_by'
        return [
            [['id'], 'integer'],
            [['fullname', 'ic', 'race', 'carplate', 'address', 'hanphone_no', 'office_no', 'email', 'make', 'model', 'tyre_size', 'batteries', 'belt', 'points', 'member_expiry', 'status', 'is_blacklist', 'is_member', 'created_by', 'created_at', 'updated_at'], 'safe'],
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
        $query = Customer::find();

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
            'is_blacklist' => $this->is_blacklist,
            'is_member' => $this->is_member,
            'points' => $this->points,
            'member_expiry' => $this->member_expiry,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'race', $this->race])
            ->andFilterWhere(['like', 'carplate', $this->carplate])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'hanphone_no', $this->hanphone_no])
            ->andFilterWhere(['like', 'office_no', $this->office_no])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'make', $this->make])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'tyre_size', $this->tyre_size])
            ->andFilterWhere(['like', 'batteries', $this->batteries])
            ->andFilterWhere(['like', 'belt', $this->belt]);

        return $dataProvider;
    }

    public function searchCustomer($fullname,$email,$carplate) {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('customer')
                    ->where(['like', 'fullname', $fullname])
                    ->andWhere(['like', 'email', $email])
                    ->andWhere(['like', 'carplate', $carplate])
                    ->all();

        return $result;            
    }   
}
