<?php

namespace app\modules\admin\models;

/**
 * This is the model class for table "access_level".
 *
 * @property int $access_level
 * @property string $access_name
 */
class AccessLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_level', 'access_name'], 'required'],
            ['access_level', 'integer'],
            ['access_name', 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'access_level' => 'Уровень доступа',
            'access_name' => 'Название',
        ];
    }
}
