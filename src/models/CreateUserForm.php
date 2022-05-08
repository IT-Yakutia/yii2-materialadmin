<?php

namespace ityakutia\materialadmin\models;

use Yii;
use common\models\User;

class CreateUserForm extends \yii\base\Model
{
	public $username;
	public $email;
	public $password;

	/**
	 * @inheritdoc
	 */
	public function rules(): array
	{
		return [
			[['username', 'email'], 'required'],
			['username', 'string'],
			['password', 'default', 'value' => null],
			['password', 'string', 'min' => 6],
			['email', 'email'],
			[['username', 'email', 'password'], 'trim', 'skipOnError' => true, 'skipOnEmpty' => true],
			[['username', 'email'], 'unique', 'targetClass' => User::class],
		];
	}

	/**
	 * @return mixed
	 * @throws \yii\base\Exception
	 */
	public function createUser()
	{
		if (!$this->validate()) {
			return $this->getFirstErrors();
		}

		if (empty($this->password)) {
			$this->password = Yii::$app->security->generateRandomString(9);
		}

		$user = new User(
			$this->getAttributes()
			+ ['status' => User::STATUS_ACTIVE]
		);
		$user->generateAuthKey();
		if($user->save()) {
			return $user;
		}

		return $user->getFirstErrors();
	}
}