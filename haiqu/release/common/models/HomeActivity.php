<?php

namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%home_activity}}".
 */
class HomeActivity extends \yii\db\ActiveRecord
{
    const TYPE_HOME_BANNER = 1;
    const TYPE_HOME_NAVIGATION=2;
    const TYPE_HOME_HOT = 3;

    public static $type =[
        self::TYPE_HOME_BANNER=>'首页banner',
        self::TYPE_HOME_NAVIGATION=>'首页导航',
        self::TYPE_HOME_HOT=>'首页热门',
    ];


    const STATUS_DOWN = -1;
    const STATUS_PENDING = 0;
    const STATUS_UP = 1;

    public static $status = [
        self::STATUS_UP=>'发布中',
        self::STATUS_PENDING=>'待审核',
        self::STATUS_DOWN=>'已撤下',

    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%home_activity}}';
    }
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

}