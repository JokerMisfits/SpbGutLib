<?php

namespace app\modules\admin\models;

/**
 * This is the model class for table "books_categories".
 *
 * @property int $id
 * @property string $name
 */
class BooksCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() : string{
        return 'books_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array{
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],
            ['name', 'unique', 'message' => 'Название категории "{value}" уже занято'],
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
