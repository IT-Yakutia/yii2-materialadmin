<?php

namespace ityakutia\materialadmin\commands;

use ityakutia\materialadmin\models\CreateUserForm;
use common\models\User;
use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Add Users and Roles to user
 */
class FakerController extends \yii\console\Controller
{
	/**
	 * Create new User
	 * @param $username
	 * @param $email
	 * @param $password
	 * @return int
	 */
    public function actionAddAdmin($username, $email, $password = null): int {

        if(YII_ENV !== 'dev') {
			$this->stdout("This method allow only dev mode.\n", Console::FG_RED);
            return ExitCode::USAGE;
        }

	    $form = new CreateUserForm([
		    'username' => $username,
		    'email' => $email,
		    'password' => $password
	    ]);

		if (($result = $form->createUser()) instanceof User) {
			$this->stdout("New user created.\n\n", Console::FG_GREEN);
			$this->stdout("Username: {$form->username}\n", Console::FG_GREEN);
			$this->stdout("Email: {$form->email}\n", Console::FG_GREEN);
			$this->stdout("Password: {$form->password}\n", Console::FG_GREEN);
			return ExitCode::OK;
		}

		$this->stdout("Error creating user:\n\n - " . implode("\n - ", $result) . "\n", Console::FG_RED);
		return ExitCode::DATAERR;
    }

	/**
	 * Assing Role to User
	 * @param $email
	 * @param $roleName
	 * @return int
	 */
    public function actionAssign($email, $roleName): int {

	    if(YII_ENV !== 'dev') {
		    $this->stdout("This method allow only dev mode.\n", Console::FG_RED);
		    return ExitCode::USAGE;
	    }

	    $user = User::find()->where(['email' => $email])->one();
        if(!$user instanceof User) {
	        $this->stdout("The user with email {$email} dose not exist.\n", Console::FG_RED);
	        return ExitCode::DATAERR;
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);

		if (empty($role)) {
			$this->stdout("The role with name {$roleName} dose not exist.\n", Console::FG_RED);
			return ExitCode::DATAERR;
		}

		try {
			$auth->assign($role, $user->id);
			$this->stdout("User {$user->username} ({$user->email}) has the role {$roleName} now.\n", Console::FG_GREEN);
			return ExitCode::OK;
		} catch(\yii\db\IntegrityException $exception) {
			$this->stdout("User {$user->username} ({$user->email}) already have role {$roleName}.\n", Console::FG_RED);
		} catch(\Throwable $exception) {
			$this->stdout("Error assigned role: {$exception->getMessage()}\n", Console::FG_RED);
		}

		return ExitCode::UNSPECIFIED_ERROR;
    }
}