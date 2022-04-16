<?php

namespace app\modules\admin\models;

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
            [['username', 'password', 'name', 'surname', 'middle_name', 'pass_number', 'department_id'], 'required'],
            [['access_level', 'parent_id', 'pass_number', 'department_id'], 'integer'],
            [['username'], 'string', 'min' => 4],
            [['password'], 'string', 'min' => 4],
            [['email'], 'string', 'min' => 6],
            [['email'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 32],
            [['password', 'auth_key', 'email'], 'string', 'max' => 255],
            [['name', 'surname', 'middle_name'], 'string', 'max' => 20],
            [['username'], 'unique'],
            [['pass_number'], 'unique'],
            [['email'], 'unique'],
            [['parent_id'], 'unique'],
            [['email'], 'email'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i','message' => '{attribute} должен начинаться и содержать символы только латинского алфавита'],
            ['pass_number', 'match', 'pattern' => '/^[0-9]{4,25}$/','message' => '{attribute} должен состоять минимум из 4 цифр, максимум 25.'],
            [['username', 'password', 'name', 'surname', 'middle_name', 'pass_number', 'email'], 'trim'],
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
