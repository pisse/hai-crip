<?php

namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%order_item}}".
 */
class OrderInvoice extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_invoice}}';
    }
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

}