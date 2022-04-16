<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "people".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $middle_name
 * @property int $access_level
 * @property string|null $comment
 * @property string|null $books
 * @property int|null $child_id
 * @property int $pass_number
 * @property int|null $department_id
 */
class People extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'people';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'middle_name', 'pass_number', 'department_id'], 'required'],
            [['access_level', 'child_id', 'pass_number', 'department_id'], 'integer'],
            [['comment'], 'string'],
            [['name', 'surname', 'middle_name', 'books'], 'string', 'max' => 255],
            [['pass_number'], 'unique'],
            [['child_id'], 'unique'],
        ];
    }
    public function getAccess(){
        $rows = (new \yii\db\Query())
            ->select('access_name')
            ->from('access_level')
            ->where(['access_level' => $this->access_level])
            ->one();
        return $rows['access_name'];
    }
    public function getDepart(){
        $rows = (new \yii\db\Query())
            ->select('name')
            ->from('department')
            ->where(['id' => $this->department_id])
            ->one();
        return $rows['name'];
    }
    public function getChild(){
        return $this->child_id;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'middle_name' => 'Отчество',
            'access_level' => 'Уровень доступа',
            'comment' => 'Коментарий',
            'books' => 'Книги',
            'child_id' => 'Аккаунт',
            'pass_number' => 'Номер пропуска',
            'department_id' => 'Кафедра',
        ];
    }
}
