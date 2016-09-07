<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * UserPassword model
 *
 * @property integer $id
 * @property string $user_id
 * @property string $password
 */
class UserPassword extends ActiveRecord
{

	const MD5_STRING = "hq_md5_pre_";
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user_password}}';
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
		];
	}
}