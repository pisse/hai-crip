<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * UserPayPassword model
 *
 * @property integer $id
 * @property string $user_id
 * @property string $password
 */
class UserPayPassword extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user_pay_password}}';
	}
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['password', 'required', 'message' => '密码不能为空'],
			['password', 'match', 'pattern' => '/^[0-9]{6}$/i', 'message' => '密码只能是6位数字'],
		];
	}
}