<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "user_permission".
 *
 * @property integer $id
 * @property string $controller
 * @property string $action
 * @property integer $role_id
 */
class UserPermission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_permission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller', 'action', 'role_id'], 'required'],
            [['role_id'], 'integer'],
            [['controller', 'action'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'controller' => 'Controller',
            'action' => 'Action',
            'role_id' => 'Role ID',
        ];
    }

    public function getUserPermission() {
        $rows = new Query();

        $result = $rows->select(['user_permission.id', 'role.role', 'user_permission.controller', 'user_permission.action', 'user_permission.role_id'])
            ->from('user_permission')
            ->join('INNER JOIN', 'role', 'user_permission.role_id = role.id')
            ->where('user_permission.role_id > 1')
            ->all();

        if( count($result) > 0 ) {
            return $result;

        }else{
            return 0;

        }   

    }
}
