<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "service_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class ServiceCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'required'],
            [['description'], 'string'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    // Search if with same name.
    public function getServiceCategories($name,$description) {
           $rows = new Query();
        
           $result = $rows->select(['name', 'description'])
            ->from('service_category')
            ->where(['name' => $name])
            ->andWhere(['description' => $description])
            ->all();
            
            if( count($result) > 0 ) {
                return TRUE;
            }else {
                return 0;
            }
    }
}
