<?php

namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%user_member}}".
 */
class UserMember extends \yii\db\ActiveRecord
{

    //会员等级
    const MEMBER_LEVEL_NORMAL = 0;
    const MEMBER_LEVEL_HARDCORE=1;


    public static $member_level = [
        self::MEMBER_LEVEL_NORMAL=>'普通会员',
        self::MEMBER_LEVEL_HARDCORE=>'铁杆会员',
    ];

    public static $member_level_fee = [
        self::MEMBER_LEVEL_NORMAL=>0,
        self::MEMBER_LEVEL_HARDCORE=>19900,
    ];

    //会员状态
    const STATUS_PENDING = 0;
    const STATUS_PAY = 1;
    const STATUS_PASS = 2;
    const STATUS_NO_PASS = -1;
    const STATUS_OVERDUE = -2;

    public static $status = [
        self::STATUS_PENDING=>'待审核',
        self::STATUS_PAY=>'已付款',
        self::STATUS_PASS=>'通过',
        self::STATUS_NO_PASS=>'不通过',
        self::STATUS_OVERDUE=>'会员过期',

    ];


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_member}}';
    }
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

}