<?php

namespace app\modules\admin\models;

use Yii;

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
            ->from('Books_categories')
            ->where(['id' => $this->category_id])
            ->one();
        return $rows['name'];
    }
    public function getSubject(){
        $rows = (new \yii\db\Query())
            ->select('name')
            ->from('Books_subjects')
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
            [['name', 'category_id', 'subject_id', 'count'], 'required'],
            [['author', 'keywords','name','annotation'], 'string'],
            [['category_id', 'subject_id', 'count', 'rest', 'stock'], 'integer'],
            [['date', 'ISBN', 'ISSN', 'publisher', 'publish_date'], 'string', 'max' => 255],
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
            'date' => 'Дата выпуска',
            'keywords' => 'Ключевые слова',
            'ISBN' => 'ISBN',
            'ISSN' => 'ISSN',
            'publisher' => 'Издатель',
            'publish_date' => 'Дата издания',
            'category_id' => 'Категория',
            'subject_id' => 'Тематика',
            'annotation' => 'Аннотация',
            'count' => 'Количество',
            'rest' => 'Остаток',
            'stock' => 'Есть в наличии',
        ];
    }
}
