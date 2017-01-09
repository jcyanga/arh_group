<?php

namespace common\models;

use Yii;
use yii\db\Query;
/**
 * This is the model class for table "gst".
 *
 * @property integer $id
 * @property string $gst
 */
class Gst extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gst';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gst','branch_id'], 'required'],
            [['gst'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gst' => 'Gst',
            'branch_id' => 'Branch Id',
        ];
    }

    // get Gst
    public function getGst() {
        $rows = new Query();

        $result = $rows->select(['gst.id', 'gst.branch_id', 'branch.name', 'gst.gst'])
                    ->from('gst')
                    ->join('INNER JOIN', 'branch', 'gst.branch_id = branch.id')
                    ->all();

        if( count($result) > 0 ) {
            return $result;

        }else{
            return 0;

        }   
        
    }

}
