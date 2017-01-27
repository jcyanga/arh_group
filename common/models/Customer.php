<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $fullname
 * @property string $race
 * @property string $carplate
 * @property string $address
 * @property string $hanphone_no
 * @property string $office_no
 * @property string $email
 * @property string $make
 * @property string $model
 * @property integer $is_blacklist
 * @property integer $is_member
 * @property integer $points
 * @property string $member_expiry
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        //    'is_blacklist',  'is_member', 'status',  'created_by',  'updated_by'
        
        // 'is_blacklist', 'is_member', 'status', 'created_by', 'updated_by'
        return [
            [['fullname', 'ic', 'password', 'race', 'carplate', 'address', 'hanphone_no', 'office_no', 'email', 'make', 'model', 'remarks', 'points', 'member_expiry', 'status', 'is_blacklist', 'is_member', 'created_by', 'created_at', 'updated_at'], 'required'],
            [['fullname', 'ic', 'address', 'is_member'], 'string'],
            [['hanphone_no', 'office_no', 'points', 'is_blacklist', 'created_by'], 'integer'],
            [['email'], 'email'],
            [['member_expiry', 'status', 'created_at', 'updated_at'], 'safe'],
            [['fullname', 'ic', 'race', 'carplate', 'hanphone_no', 'office_no', 'email', 'make', 'model'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'race' => 'Race',
            'carplate' => 'Carplate',
            'address' => 'Address',
            'hanphone_no' => 'Hanphone No',
            'office_no' => 'Office No',
            'email' => 'Email',
            'make' => 'Make',
            'model' => 'Model',
            'remarks' => 'Remarks',
            'is_blacklist' => 'Is Blacklist',
            'is_member' => 'Is Member',
            'points' => 'Points',
            'member_expiry' => 'Member Expiry',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'ic' => 'IC',
            // 'updated_by' => 'Updated By',
        ];
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

}
