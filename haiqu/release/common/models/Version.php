<?php

namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%version}}".
 */
class Version extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'new_version', 'new_features','new_ios_version', 'ard_url', 'ard_size'], 'required', 'message' => '不能为空'],
            ['has_upgrade', 'default', 'value' => 0],
            ['is_force_upgrade', 'default', 'value' => 0],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '类型',
            'has_upgrade' => 'has_upgrade',
            'is_force_upgrade' => 'is_force_upgrade',
            'new_version' => 'Android版本号',
            'new_ios_version' => 'IOS版本号',
            'new_features' => '新版本描述',
            'ard_url' => '现在地址',
            'ard_size' => '大小',
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%version}}';
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

}