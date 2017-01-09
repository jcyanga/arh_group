<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Gst;

use yii\db\Query;

/**
 * SearchGst represents the model behind the search form about `common\models\Gst`.
 */
class SearchGst extends Gst
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','branch_id'], 'integer'],
            [['gst'], 'safe'],
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
        $query = Gst::find();

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

        $query->andFilterWhere(['like', 'gst', $this->gst]);

        return $dataProvider;
    }

    public function searchBranch($branch_id) {
        $rows = new Query();

        $result = $rows->select(['gst.id', 'gst.branch_id', 'branch.name', 'gst.gst'])
                    ->from('gst')
                    ->join('INNER JOIN', 'branch', 'gst.branch_id = branch.id')
                    ->where(['gst.branch_id' => $branch_id])
                    ->all();

        if( count($result) > 0 ) {
            return $result;

        }else{
            return 0;

        }   

    }

    public function searchGst($branch_id) {
        $rows = new Query();

        $result = $rows->select(['*'])
                    ->from('gst')
                    ->where(['gst.branch_id' => $branch_id])
                    ->all();

        if( count($result) > 0 ) {
            return TRUE;

        }else{
            return 0;

        }   

    }

}
