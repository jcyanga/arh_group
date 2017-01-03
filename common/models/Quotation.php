<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "quotation".
 *
 * @property integer $id
 * @property string $quotation_code
 * @property integer $user_id
 * @property integer $customer_id
 * @property integer $branch_id
 * @property string $date_issue
 * @property string $type
 * @property integer $no_of_services
 * @property integer $no_of_parts
 * @property double $grand_total
 * @property string $remarks
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $delete
 */
class Quotation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_code', 'user_id', 'customer_id', 'branch_id', 'date_issue', 'type', 'no_of_services', 'no_of_parts', 'grand_total', 'remarks', 'created_at', 'created_by', 'updated_at', 'updated_by', 'delete'], 'required'],
            [['user_id', 'customer_id', 'branch_id', 'no_of_services', 'no_of_parts', 'created_by', 'updated_by', 'delete'], 'integer'],
            [['date_issue', 'created_at', 'updated_at'], 'safe'],
            [['grand_total'], 'number'],
            [['remarks'], 'string'],
            [['quotation_code', 'type'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_code' => 'Quotation Code',
            'user_id' => 'User ID',
            'customer_id' => 'Customer ID',
            'branch_id' => 'Branch ID',
            'date_issue' => 'Date Issue',
            'type' => 'Type',
            'no_of_services' => 'No Of Services',
            'no_of_parts' => 'No Of Parts',
            'grand_total' => 'Grand Total',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'delete' => 'Delete',
        ];
    }

    // get id
    public function getQuotationId() {
        $rows = new Query();

        $result = $rows->select(['Max(id) as quotation_id'])
                        ->from('quotation')
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['quotation_id'] + 1;
        
        }else {
            return 0;
        
        }                
    
    }

    // get branch
    public function getBranch() {
        $rows = new Query();

        $result = $rows->select(['concat(code," | ",name) as branchList, id'])
        ->from('branch')
        ->all();

        if( count($result) > 0 ) {
            return $result;
        
        }else {
            return 0;
        
        }   

    }

    // get user
    public function getUser() {
        $rows = new Query();

        $result = $rows->select(['concat(role.role," | ",user.fullname) as userList, user.id'])
        ->from('user')
        ->join('INNER JOIN', 'role', 'user.role_id = role.id')
        ->where('user.role_id >= 2')
        ->andWhere('user.role_id <= 3')
        ->all();

        if( count($result) > 0 ) {
            return $result;
        
        }else {
            return 0;
        
        }   

    }

    // get customer
    public function getCustomer() {
        $rows = new Query();

        $result = $rows->select(['concat(carplate," | ",fullname) as customerList, id'])
        ->from('customer')
        ->all();

        if( count($result) > 0 ) {
            return $result;
        
        }else {
            return 0;
        
        }   

    }


}
