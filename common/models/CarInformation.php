<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_information".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $carplate
 * @property string $make
 * @property string $model
 * @property string $engine_no
 * @property string $year_mfg
 * @property string $chasis
 * @property integer $points
 * @property integer $type
 * @property integer $status
 */
class CarInformation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_information';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['carplate', 'make', 'model', 'engine_no', 'year_mfg', 'chasis', 'points'], 'safe'],
            [['customer_id', 'points', 'type', 'status'], 'integer'],
            [['carplate', 'make', 'model', 'engine_no', 'chasis'], 'string', 'max' => 50],
            [['year_mfg'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'carplate' => 'Carplate',
            'make' => 'Make',
            'model' => 'Model',
            'engine_no' => 'Engine No',
            'year_mfg' => 'Year Mfg',
            'chasis' => 'Chasis',
            'points' => 'Points',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }
}
