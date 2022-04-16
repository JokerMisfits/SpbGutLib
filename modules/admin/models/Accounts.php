<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "accounts".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $auth_key
 * @property int $access_level
 * @property string $name
 * @property string $surname
 * @property string $middle_name
 * @property string|null $email
 * @property int|null $parent_id
 * @property int $pass_number
 * @property int $department_id
 */
class Accounts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accounts';
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
    public function getParent(){
        return $this->parent_id;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'access_level', 'name', 'surname', 'middle_name', 'pass_number', 'department_id'], 'required'],
            [['access_level', 'parent_id', 'pass_number', 'department_id'], 'integer'],
            [['username', 'password', 'auth_key', 'name', 'surname', 'middle_name', 'email'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['pass_number'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'auth_key' => 'Auth Key',
            'access_level' => 'Уровень доступа',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'middle_name' => 'Отчество',
            'email' => 'Email',
            'parent_id' => 'Пользователь',
            'pass_number' => 'Номер пропуска',
            'department_id' => 'Кафедра',
        ];
    }
}
