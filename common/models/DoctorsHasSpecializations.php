<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "doctors_has_specializations".
 *
 * @property int $id
 * @property int $doctor_id
 * @property int $specialization_id
 * @property string $created_at
 * @property string $updated_at
 */
class DoctorsHasSpecializations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctors_has_specializations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doctor_id', 'specialization_id', 'created_at', 'updated_at'], 'required'],
            [['doctor_id', 'specialization_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctor_id' => 'Doctor ID',
            'specialization_id' => 'Specialization ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
