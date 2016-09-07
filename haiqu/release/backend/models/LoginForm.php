<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\UserCaptcha;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
    public $phoneCaptcha;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
    	if (YII_ENV == 'dev') {
    		return [
	            [['username', 'password'], 'required'],
	            ['password', 'validatePassword'],
	        ];
    	} else {
	        return [
	            [['username', 'password', 'phoneCaptcha'], 'required'],
	            //['verifyCode', 'captcha', 'captchaAction' => 'main/captcha'],
	            ['phoneCaptcha', 'validatePhoneCaptcha'],
	            ['password', 'validatePassword'],
	        ];
    	}
    }
    
    public function attributeLabels()
    {
    	return [
    		'username' => '用户名',
    		'password' => '密码',
    		'verifyCode' => '验证码',
    		'phoneCaptcha' => '验证码',
    	];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误');
            }
        }
    }
    
    /**
     * Validates the phoneCaptcha.
     */
    public function validatePhoneCaptcha($attribute, $params)
    {
    	if (!$this->hasErrors()) {
    		$user = $this->getUser();
    		$userService = Yii::$container->get('userService');
    		if (!$user || !$userService->validatePhoneCaptcha($user->phone, $this->phoneCaptcha, UserCaptcha::TYPE_ADMIN_LOGIN)) {
    			$this->addError($attribute, '验证码错误');
    		}
    	}
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = AdminUser::findByUsername($this->username);
        }

        return $this->_user;
    }
}
