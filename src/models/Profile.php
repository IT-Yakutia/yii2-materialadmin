<?php

namespace ityakutia\materialadmin\models;

use common\models\Auth;
use common\models\User;
use yii\base\Model;
use Yii;

class Profile extends Model
{
    const SCENARIO_PWD = 'change_pwd';
    const SCENARIO_PROFILE = 'change_profile';

    public $_user;

    public $username;
    public $email;

    public $oldUsername;
    public $oldEmail;

    public $old_password;
    public $password;
    public $password_repeat;

    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PWD] = ['password', 'password_repeat', 'old_password'];
        $scenarios[self::SCENARIO_PROFILE] = ['username', 'email', 'oldUsername', 'oldEmail'];
        return $scenarios;
    }

    public function rules() {
        return [
            [['username', 'email'], 'required', 'on' => self::SCENARIO_PROFILE],
            ['username', 'trim', 'on' => self::SCENARIO_PROFILE],
            ['username', 'required', 'on' => self::SCENARIO_PROFILE],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин занят.', 'filter' => ['!=', 'username', $this->oldUsername], 'on' => self::SCENARIO_PROFILE],
            ['username', 'string', 'min' => 2, 'max' => 255, 'on' => self::SCENARIO_PROFILE],

            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот email занят.', 'filter' => ['!=', 'email', $this->oldEmail], 'on' => self::SCENARIO_PROFILE],
            ['email', 'email', 'on' => self::SCENARIO_PROFILE],

            ['old_password', 'validatePassword'],
            [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_PWD],
            ['password', 'string', 'min' => 6, 'on' => self::SCENARIO_PWD],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли введенные вами не совпадают', 'on' => self::SCENARIO_PWD],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->old_password)) {
                $this->addError($attribute, 'Не правильно ввели пароль.');
            }
        }
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Yii::$app->user->identity;
        }

        return $this->_user;
    }

    public function loadFromItem($item)
    {
        $this->username = $item->username;
        $this->email = $item->email;
        $this->oldUsername = $item->username;
        $this->oldEmail = $item->email;
    }

    public function edit($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->username = $this->username;

        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function repwd($item)
    {
        if (!$this->validate()) {
            return null;
        }

        $item->setPassword($this->password);

        if ($item->save()) {
            return true;
        }

        return null;
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'old_password' => 'Старый пароль',
            'password' => 'Новый пароль',
            'password_repeat' => 'Подтвердите пароль',
        ];
    }

    public function getSourceAuth()
    {
        return Auth::find()->where(['user_id' => $this->getUser()->id])->one();
    }

}
