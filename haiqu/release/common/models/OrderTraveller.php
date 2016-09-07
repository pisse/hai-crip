<?php

namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%order_item}}".
 */
class OrderTraveller extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_traveller}}';
    }
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

}