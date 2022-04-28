<?php

namespace app\modules\admin\models;

/**
 * This is the model class for table "accounts".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $password_confirm
 * @property string|null $auth_key
 * @property int $access_level
 * @property string $name
 * @property string $surname
 * @property string $middle_name
 * @property string|null $email
 * @property int|null $parent_id
 * @property int $pass_number
 * @property int $department_id
 * @property string $phone
 * @property int $registration_timestamp
 * @property int $last_activity_timestamp
 */
class Accounts extends \yii\db\ActiveRecord
{

    const SCENARIO_FORM = 'form';
    const SCENARIO_SAVE = 'save';
    public $password_confirm;

    /**
     * {@inheritdoc}
     */
    public static function tableName() : string{
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

    public function getParent() : int{
        return $this->parent_id;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array{
        return [
            [['username', 'password', 'name', 'surname', 'middle_name', 'pass_number', 'department_id'], 'required'],
            ['password_confirm', 'required', 'on' => self::SCENARIO_FORM],
            ['registration_timestamp', 'required', 'on' => self::SCENARIO_SAVE],
            ['access_level', 'default', 'value' => 0],
            [['access_level', 'parent_id', 'pass_number', 'department_id'], 'integer'],
            ['phone', 'string', 'min' => 11],
            ['phone', 'string', 'max' => 20],
            ['phone', 'filter', 'filter' => [$this, 'normalizePhone'], 'on' => self::SCENARIO_SAVE],
            ['username', 'string', 'min' => 4],
            [['password','password_confirm'], 'string', 'min' => 4],
            ['email', 'default', 'value' => null, 'on' => self::SCENARIO_SAVE],
            ['email', 'string', 'min' => 6],
            ['username', 'string', 'max' => 32],
            [['password', 'auth_key', 'email', 'password_confirm'], 'string', 'max' => 255],
            [['name', 'surname', 'middle_name'], 'string', 'max' => 20],
            ['registration_timestamp', 'string', 'max' => 12],
            ['last_activity_timestamp', 'string', 'max' => 12],
            ['username', 'unique', 'message' => 'Логин "{value}" уже занят.'],
            ['pass_number', 'unique',  'message' => 'Номер пропуска/удостоверения "{value}" уже занят.'],
            ['email', 'unique', 'message' => 'Email "{value}" уже занят.'],
            ['parent_id', 'unique'],
            ['email', 'email'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i','message' => '{attribute} должен начинаться и содержать символы только латинского алфавита.'],
            ['pass_number', 'match', 'pattern' => '/^[0-9]{4,25}$/','message' => '{attribute} должен состоять минимум из 4 цифр, максимум 25.'],
            ['phone', 'match', 'pattern' => '/^[0-9]{11,20}$/','message' => '{attribute} должен состоять минимум из 11 цифр, максимум 20.'],
            [['username', 'password', 'name', 'surname', 'middle_name', 'password_confirm'], 'trim'],
            'confirm' => ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array{
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_confirm' => 'Повторите пароль',
            'auth_key' => 'Auth Key',
            'access_level' => 'Уровень доступа',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'middle_name' => 'Отчество',
            'email' => 'Email',
            'parent_id' => 'Пользователь',
            'pass_number' => 'Номер пропуска',
            'department_id' => 'Кафедра',
            'phone' => 'Номер телефона',
            'registration_timestamp' => 'Дата регистрации',
            'last_activity_timestamp' => 'Активность',
        ];
    }

    public function normalizePhone($value) : string {
        if((string)$value[0] == 7){
            $value[0] = 8;
        }
        return $value;
    }

    public function fields() : array{
        $fields = parent::fields();
        unset($fields['password'], $fields['password_confirm'], $fields['auth_key']);
        return $fields;
    }

    public function beforeValidate() : bool{
        if (parent::beforeValidate()) {
            if($this->scenario == self::SCENARIO_SAVE){
                $this->password_confirm = $this->password;
            }
        }
        return true;
    }

    public function beforeSave($insert) : bool{
        if (parent::beforeSave('beforeInsert')) {
            if($this->email != null){
                $this->email = trim($this->email);
                if($this->email == ''){
                    $this->email = null;
                }
            }
        }
        return true;
    }

}
