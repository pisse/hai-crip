<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * AdminUser model
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 */
class AdminUser extends ActiveRecord implements IdentityInterface
{
	// 超级管理员角色标识
	const SUPER_ROLE		= 'superadmin';
	// 超级管理员固定用户名
	const SUPER_USERNAME	= 'admin';
	
	// 手机验证正则表达式
	const PHONE_PATTERN = '/^1[0-9]{10}$/';
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_user}}';
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
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
            ['mark', 'safe'],
    		[['username', 'phone', 'role', 'password'], 'required'],
    		['username', 'match', 'pattern' => '/^[0-9A-Za-z_]{1,30}$/i', 'message' => '用户名只能是1-30位字母、数字或下划线'],
    		['username', 'unique'],
    		['phone', 'match', 'pattern' => self::PHONE_PATTERN, 'message' => '手机号格式错误'],
    		['password', 'string', 'length' => [6, 16], 'message' => '密码为6-16位字符或数字', 'tooShort'=>'密码为6-16位字符或数字', 'tooLong'=>'密码为6-16位字符或数字'],
    	];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	return [
            'id' => '管理员ID',
    		'username' => '用户名',
    		'phone' => '手机号',
            'role' => '角色',
    		'mark' => '备注/姓名',
    		'password' => '密码',
            'created_user' => '创建人',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
    	];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    	throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
    
    /**
     * 判断是否是超级管理员
     */
    public function getIsSuperAdmin()
    {
    	return $this->role == self::SUPER_ROLE;
    }
}
