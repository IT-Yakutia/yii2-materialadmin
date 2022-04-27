<?php


namespace ityakutia\materialadmin\commands;


use common\models\User;
use Faker\Factory;
use Yii;
use yii\console\Controller;
use yii\db\Expression;

class FakerController extends Controller
{

    public $faker;

    public function init()
    {
        $this->faker = Factory::create();
        parent::init();
    }

    /*
     * php yii faker/add-admin "+79990000000" example@gmail.com
     */
    public function actionAddAdmin($username, $email, $password = '000000') {

        if(YII_ENV !== 'dev') {
            return false;
        }

        $isUserExists = User::find()->where(['email' => $email])->exists();
        if($isUserExists) {
           return false;
        }

        $user = new User([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'created_at' => time(),
            'updated_at' => time(),
            'status' => 10,
        ]);
        $user->generateAuthKey();
        if($user->save())
            echo $user->username . "\n";
        else {
            echo var_dump($user->errors);
            echo "\n";
        }

        return true;
    }

    public function actionAssign($email, $roleName) {

        if(YII_ENV !== 'dev') {
            echo var_dump("This method allow only dev mode.");
            echo "\n";
            return false;
        }

        $isUserExists = User::find()->where(['email' => $email])->exists();
        if(!$isUserExists) {
            echo var_dump("The user with email $email dose not exist.");
            echo "\n";
            return false;
        }

        $user = User::find()->where(['email' => $email])->one();
        
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);

        if($role != null || $role != false){
            $auth->assign($role, $user->id);
            echo $user->email . " has the role: " . $roleName . " now.\n";
        } else {
            echo var_dump("The role with name $role dose not exist.");
            echo "\n";
        }

        return true;
    }
}