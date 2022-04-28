<?php

namespace app\modules\admin\models;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() : string{
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array{
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'unique', 'message' => 'Название кафедры "{value}" уже занято'],
            ['name', 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array{
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }
}
