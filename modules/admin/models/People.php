<?php

namespace app\modules\admin\models;

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

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public static function tableName() : string{
        return 'people';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array{
        return [
            [['name', 'surname', 'middle_name', 'pass_number', 'department_id'], 'required'],
            [['access_level', 'child_id', 'pass_number', 'department_id'], 'integer'],
            ['comment', 'default', 'value' => null, 'on' => self::SCENARIO_CREATE],
            ['comment', 'string', 'min' => 4, 'on' => self::SCENARIO_UPDATE],
            ['comment','string', 'max' => 255],
            ['books', 'string'],
            [['name', 'surname', 'middle_name'], 'string', 'max' => 20],
            ['pass_number', 'unique', 'message' => 'Номер пропуска/удостоверения "{value}" уже занят'],
            ['child_id', 'unique'],
            ['pass_number', 'match', 'pattern' => '/^[0-9]{4,25}$/','message' => '{attribute} должен состоять минимум из 4 чисел, максимум 25.'],
            [['name', 'surname', 'middle_name'], 'trim'],
            ['comment', 'trim', 'on' => self::SCENARIO_UPDATE],// Иначе trim удаляет null, для сценария create
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
    public function attributeLabels() : array{
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'middle_name' => 'Отчество',
            'access_level' => 'Уровень доступа',
            'comment' => 'Комментарий',
            'books' => 'Книги',
            'child_id' => 'Аккаунт',
            'pass_number' => 'Номер пропуска',
            'department_id' => 'Кафедра',
        ];
    }

    public function beforeSave($insert) : bool{
        if (parent::beforeSave('beforeInsert')) {
            if($this->comment != null){
                $this->comment = trim($this->comment);
                if($this->comment == ''){
                    $this->comment = null;
                }
            }
        }
        return true;
    }

}
