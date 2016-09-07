<?php
namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * AdminUserRole model
 */
class AdminUserRole extends \yii\db\ActiveRecord
{
     // 角色分组类型
    const TYPE_SERVICE = 1;//客服
    const TYPE_OPERATE = 2;//运营
    const TYPE_PRODUCT = 3;//产品
    const TYPE_FINANCE = 4;//财务
    const TYPE_DEVELOP = 5;//开发
    const TYPE_TEST = 6;//测试
    const TYPE_OPERATION = 7;//职能
    const TYPE_PROPERTY = 8;//资产
    
    public static $status = [
        self::TYPE_FINANCE  => '财务组',
        self::TYPE_DEVELOP  => '开发组',
        self::TYPE_OPERATION => '业务组',
        self::TYPE_PROPERTY => '风控组',
        self::TYPE_SERVICE  => '客服组',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_user_role}}';
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
    		[['name', 'title'], 'required'],
    		['name', 'match', 'pattern' => '/^[0-9A-Za-z_]{1,30}$/i', 'message' => '标识只能是1-30位字母、数字或下划线'],
    		['name', 'unique'],
    		[['desc', 'permissions' ,'groups'], 'safe'],
    	];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	return [
    		'name' => '标识',
    		'title' => '名称',
    		'desc' => '角色描述',
    		'permissions' => '权限',
            'groups' => '分组',
    	];
    }
    
    public static function findAllSelected()
    {
    	$roles = self::find()->asArray()->all();
    	$rolesItems = array();
    	foreach ($roles as $v) {
            $rolesItems[$v['groups']][$v['name']]['title'] = $v['title'];
    		$rolesItems[$v['groups']][$v['name']]['desc'] = $v['desc'];
    	}
    	return $rolesItems;
    }
}