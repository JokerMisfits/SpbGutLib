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

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

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
            [['name', 'date', 'category_id', 'subject_id', 'count'], 'required'],
            [['name', 'author', 'keywords', 'annotation', 'comment'], 'string'],
            [['category_id', 'subject_id', 'count', 'rest', 'stock'], 'integer'],
            ['name', 'unique', 'message' => 'Название "{value}" уже занято'],
            ['count', 'integer', 'min' => 0, 'on' => self::SCENARIO_UPDATE],
            ['count', 'integer', 'min' => 1, 'on' => self::SCENARIO_CREATE],
            ['count', 'integer', 'max' => 999],
            [['keywords', 'comment'], 'string', 'min' => 4],
            ['annotation', 'string', 'min' => 20],
            [['date', 'publish_date'], 'string', 'min' => 1],
            [['date', 'publish_date'], 'string', 'max' => 4],
            [['ISBN', 'ISSN'], 'string', 'max' => 25],
            [['name', 'author', 'publisher', 'keywords', 'comment'], 'string', 'max' => 255],
            [['date', 'publish_date'], 'match', 'pattern' => '/^[0-9]{4}$/','message' => '{attribute} должна состоять из 4 чисел'],
            [['ISBN', 'ISSN'], 'match', 'pattern' => '/^[0-9-]+$/i','message' => '{attribute} должна состоять только из чисел и дефисов 978-5-9268-2477-0'],
            [['author', 'ISBN', 'ISSN', 'publisher', 'publish_date', 'annotation', 'comment', 'keywords'], 'default', 'value' => null, 'on' => self::SCENARIO_CREATE],
            ['name', 'trim'],
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
            'date' => 'Год первой публикации',
            'keywords' => 'Ключевые слова',
            'ISBN' => 'ISBN',
            'ISSN' => 'ISSN',
            'publisher' => 'Издатель',
            'publish_date' => 'Год издания',
            'category_id' => 'Категория',
            'subject_id' => 'Тематика',
            'annotation' => 'Аннотация',
            'comment' => 'Комментарий',
            'count' => 'Количество',
            'rest' => 'Остаток',
            'stock' => 'Есть в наличии',
        ];
    }

    public function beforeSave($insert){
        if (parent::beforeSave('beforeInsert')) {
            if($this->author != null){
                $this->author = trim($this->author);
                if($this->author == ''){
                    $this->author = null;
                }
            }
            if($this->ISBN != null){
                $this->ISBN = trim($this->ISBN);
                if($this->ISBN == ''){
                    $this->ISBN = null;
                }
            }
            if($this->ISSN != null){
                $this->ISSN = trim($this->ISSN);
                if($this->ISSN == ''){
                    $this->ISSN = null;
                }
            }
            if($this->publisher != null){
                $this->publisher = trim($this->publisher);
                if($this->publisher == ''){
                    $this->publisher = null;
                }
            }
            if($this->annotation != null){
                $this->annotation = trim($this->annotation);
                if($this->annotation == ''){
                    $this->annotation = null;
                }
            }
            if($this->comment != null){
                $this->comment = trim($this->comment);
                if($this->comment == ''){
                    $this->comment = null;
                }
            }
            if($this->keywords != null){
                $this->keywords = trim($this->keywords);
                if($this->keywords == ''){
                    $this->keywords = null;
                }
            }
        }
        return true;
    }
}
