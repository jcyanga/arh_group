<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $product_code
 * @property string $product_name
 * @property string $product_image
 * @property string $unit_of_measure
 * @property integer $status
 * @property integer $category_id
 * @property string $created_at
 * @property integer $created_by
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_code', 'product_name', 'unit_of_measure', 'status', 'category_id', 'created_at', 'created_by'], 'required'],
            [['status', 'category_id', 'created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['product_code', 'product_name', 'product_image', 'unit_of_measure'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_code' => 'Product Code',
            'product_name' => 'Product Name',
            'product_image' => 'Product Image',
            'unit_of_measure' => 'Unit Of Measure',
            'status' => 'Status',
            'category_id' => 'Category ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

}
