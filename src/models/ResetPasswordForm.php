<?php

namespace ityakutia\materialadmin\models;

use yii\base\Model;
use yii\base\InvalidArgumentException;
use common\models\User;

class ResetPasswordForm extends Model
{
    public $password;
    public $passwordRe;

    /**
     * @var User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['password', 'passwordRe'], 'required'],
            ['password', 'string', 'min' => 6],
            ['passwordRe', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match" ],
        ];
    }

    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
