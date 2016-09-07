<?php

namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%prod_spu}}".
 */
class ProdSpu extends \yii\db\ActiveRecord{

    /**
     * 旅游类型
     */
    const SPU_TYPE_ONE = 1;
    const SPU_TYPE_TWO = 2;

    public static $spu_type_list =[
        self::SPU_TYPE_ONE=>'旅游类型一',
        self::SPU_TYPE_TWO=>'旅游类型二',
    ];

    /**
     * 旅游性质
     */
    const SPU_NATURE_ONE = 1;
    const SPU_NATURE_TWO = 2;

    public static $spu_nature_list =[
        self::SPU_NATURE_ONE=>'旅游性质一',
        self::SPU_NATURE_TWO=>'旅游性质二',
    ];


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'spu_id' => '产品编号',
            'spu_type' => '旅游类型',
            'spu_nature' => '旅游性质',
            'title' => '产品标题',
            'promotion' => '促销语',
            'intro' => '产品简介',
            'price_adult' => '成人价',
            'price_kid' => '儿童价',
            'place_gather' => '集合地',
            'place_destination' => '目的地',
            'intro_destination' => '目的地介绍',
            'days_travel' => '行程天数',
            'pic_num' => '图片数量',
            'pic_main' => '主图url',
            'pic_little' => '缩略图url',
            'line_intro' => '线路亮点',
            'activity_intro' => '活动说明',
            'enter_intro' => '报名流程',
            'group_notice' => '出团通知',
            'fee_intro' => '费用信息',
            'sth_notice' => '注意事项',
            'enter_notice' => '报名提醒',
            'supplier' => '供应商',
            'created_by' => '创建人',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%prod_spu}}';
    }
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

}