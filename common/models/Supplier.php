<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "supplier".
 *
 * @property integer $id
 * @property string $supplier_code
 * @property string $supplier_name
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_code', 'supplier_name', 'address', 'contact_number'], 'required'],
            [['contact_number'], 'integer'],
            [['supplier_code', 'supplier_name', 'address'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_code' => 'Supplier Code',
            'supplier_name' => 'Supplier Name',
            'address' => 'Address',
            'contact_number' => 'Contact Number',
        ];
    }

    // Search if with same name.
    public function getSuppliers($supplier_code,$supplier_name) {
           $rows = new Query();
        
           $result = $rows->select(['supplier_code', 'supplier_name'])
            ->from('supplier')
            ->where(['supplier_code' => $supplier_code])
            ->andWhere(['supplier_name' => $supplier_name])
            ->all();
            
            if( count($result) > 0 ) {
                return TRUE;
            }else {
                return 0;
            }
    }
}
