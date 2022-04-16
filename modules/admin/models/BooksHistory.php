<?php

namespace app\modules\admin\models;

/**
 * This is the model class for table "books_history".
 *
 * @property int $id
 * @property int $book_id
 * @property int $user_id
 * @property string $date_from
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
    public function getBook(){
        $rows = (new \yii\db\Query())
            ->select('name')
            ->from('books')
            ->where(['id' => $this->book_id])
            ->one();
        return $rows['name'];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'user_id', 'date_from', 'count'], 'required'],
            [['book_id', 'user_id', 'active', 'count'], 'integer'],
            ['date_from', 'string', 'min' => 10],
            ['count', 'integer', 'min' => 0],
            ['count', 'integer', 'max' => 999],
            ['comment', 'string', 'min' => 4],
            ['comment', 'string', 'max' => 255],
            [['date_from', 'date_end'], 'string', 'max' => 30],
            ['comment', 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Название книги',
            'user_id' => 'Ссылка пользователя',
            'date_from' => 'Когда взял',
            'date_end' => 'Когда вернул',
            'comment' => 'Комментарий',
            'active' => 'Активно',
            'count' => 'Количество',
        ];
    }
}
