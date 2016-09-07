<?php

namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%order}}".
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_CANCEL_USER = -1;
    const STATUS_CANCEL_SYS = -2;
    const STATUS_INIT = 0;
    const STATUS_AUDIT = 1;
    const STATUS_PAYED = 2;
    const STATUS_SUCC = 3;

    public static $status = [
        self::STATUS_CANCEL_USER => '取消',
        self::STATUS_CANCEL_SYS => '系统取消',
        self::STATUS_INIT => '未审核',
        self::STATUS_AUDIT => '审核通过',
        self::STATUS_PAYED => '支付成功',
        self::STATUS_SUCC => '完成',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_main}}';
    }
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     *
     */
    public static function getOrders() {
        $sql = "";
        $rows=Yii::$app->db->createCommand($sql)->query();
        return array(
            [],
            []
        );
    }

    public static function applyOrder() {
//        $connection->createCommand()->insert('user', [
//            'name' => 'Sam',
//            'age' => 30,
//        ])->execute();

        // INSERT 一次插入多行
//        $connection->createCommand()->batchInsert('user', ['name', 'age'], [
//            ['Tom', 30],
//            ['Jane', 20],
//            ['Linda', 25],
//        ])->execute();

        // UPDATE
//        $connection->createCommand()->update('user', ['status' => 1], 'age > 30')->execute();




        //事务的基本结构(多表更新插入操作请使用事务处理)
        $dbTrans= Yii::app()->db->beginTransaction();
        $dbTrans->commit();
        $dbTrans->rollback();



}