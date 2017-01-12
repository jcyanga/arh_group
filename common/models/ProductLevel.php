<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_level".
 *
 * @property integer $id
 * @property integer $minimum_level
 * @property integer $critical_level
 */
class ProductLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['minimum_level', 'critical_level'], 'required'],
            [['minimum_level', 'critical_level'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'minimum_level' => 'Minimum Level',
            'critical_level' => 'Critical Level',
        ];
    }
}
