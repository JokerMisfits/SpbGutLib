<?php

namespace app\modules\admin\models;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $name
 * @property string|null $author
 * @property string|null $date
 * @property string|null $keywords
 * @property string|null $ISBN
 * @property string|null $ISSN
 * @property string|null $publisher
 * @property string|null $publish_date
 * @property string|null $annotation
 * @property string|null $comment
 * @property int $category_id
 * @property int $subject_id
 * @property int $count
 * @property int $rest
 * @property int $stock
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }
    public function getCategory(){
        $rows = (new \yii\db\Query())
            ->select('name')
            ->from('books_categories')
            ->where(['id' => $this->category_id])
            ->one();
        return $rows['name'];
    }
    public function getSubject(){
        $rows = (new \yii\db\Query())
            ->select('name')
            ->from('books_subjects')
            ->where(['id' => $this->subject_id])
            ->one();
        return $rows['name'];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date', 'category_id', 'subject_id','count'], 'required'],
            [['name', 'author', 'keywords', 'annotation', 'comment'], 'string'],
            [['category_id', 'subject_id', 'count', 'rest', 'stock'], 'integer'],
            ['count', 'integer', 'min' => 0],
            ['count', 'integer', 'max' => 999],
            [['keywords', 'comment'], 'string', 'min' => 4],
            ['annotation', 'string', 'min' => 20],
            [['date', 'publish_date'], 'string', 'min' => 1],
            [['date', 'publish_date'], 'string', 'max' => 4],
            [['ISBN', 'ISSN'], 'string', 'max' => 25],
            [['name','author','publisher','keywords','comment'], 'string', 'max' => 255],
            [['date','publish_date'], 'match', 'pattern' => '/^[0-9]{4}$/','message' => '{attribute} должна состоять из 4 чисел'],
            [['ISBN','ISSN'], 'match', 'pattern' => '/^[0-9-]+$/i','message' => '{attribute} должна состоять только из чисел и дефисов 978-5-9268-2477-0'],
            [['name', 'date', 'author', 'keywords', 'annotation', 'comment'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'author' => 'Авторы',
            'date' => 'Дата публикации',
            'keywords' => 'Ключевые слова',
            'ISBN' => 'ISBN',
            'ISSN' => 'ISSN',
            'publisher' => 'Издатель',
            'publish_date' => 'Дата издания',
            'category_id' => 'Категория',
            'subject_id' => 'Тематика',
            'annotation' => 'Аннотация',
            'comment' => 'Комментарий',
            'count' => 'Количество',
            'rest' => 'Остаток',
            'stock' => 'Есть в наличии',
        ];
    }
}
