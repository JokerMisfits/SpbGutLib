<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "books_history".
 *
 * @property int $id
 * @property int $book_id
 * @property int $user_id
 * @property string $date
 * @property string|null $date_end
 * @property string|null $comment
 * @property int $active
 * @property int $count
 */
class BooksHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'user_id', 'date'], 'required'],
            [['book_id', 'user_id', 'active', 'count'], 'integer'],
            [['comment'], 'string'],
            [['date', 'date_end'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'user_id' => 'Ссылка пользователя',
            'date' => 'Когда взял',
            'date_end' => 'Когда вернул',
            'comment' => 'Комментарий',
            'active' => 'Вернул',
            'count' => 'Количество',
        ];
    }
}
