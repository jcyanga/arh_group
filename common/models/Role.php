<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $role
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role'], 'required'],
            [['role'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
        ];
    }

    // Search if with same name.
    public function getRole($role) {
           $rows = new Query();
        
           $result = $rows->select(['role'])
            ->from('role')
            ->where(['role' => $role])
            // ->andWhere(['email' => $email])
            ->all();
            
            if( count($result) > 0 ) {
                return TRUE;
            }else {
                return 0;
            }
    }
}
