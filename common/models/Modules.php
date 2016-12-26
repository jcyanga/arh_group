<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "modules".
 *
 * @property integer $id
 * @property string $modules
 */
class Modules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modules'], 'required'],
            [['modules'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'modules' => 'Modules',
        ];
    }

    // Search if with same name.
    public function getModules($modules) {
           $rows = new Query();
        
           $result = $rows->select(['modules'])
            ->from('modules')
            ->where(['modules' => $modules])
            // ->andWhere(['email' => $email])
            ->all();
            
            if( count($result) > 0 ) {
                return TRUE;
            }else {
                return 0;
            }
    }
}
