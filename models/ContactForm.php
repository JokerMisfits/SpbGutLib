<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */

class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Необходимо заполнить ФИО.'],
            ['name', 'string', 'min' => 6],
            ['name', 'string', 'max' => 255],
            ['email', 'required', 'message' => 'Необходимо заполнить Email.'],
            ['subject', 'required', 'message' => 'Необходимо выбрать тему обращения.'],
            ['body', 'required', 'message' => 'Необходимо заполнить текст.'],
            ['body', 'string', 'min' => 10],
            ['body', 'string', 'max' => 1000],
            ['email', 'email'],
            ['email', 'string', 'min' => 6],
            ['email', 'string', 'max' => 255],
            ['verifyCode', 'captcha'],
            [['name', 'email', 'body'], 'trim'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'ФИО',
            'email' => 'Email',
            'subject' => 'Причина обращения',
            'body' => 'Сообщение',
            'verifyCode' => 'Код подтверждения',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            $this->body = $this->name . "\n" .  $this->body;
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
