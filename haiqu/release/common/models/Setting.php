<?php

namespace common\models;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property string $skey
 * @property string $svalue
 * @property string $stext
 */
class Setting extends ActiveRecord
{
    public $comment;
    const KEY_PREFIX = "page_";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * Find by key
     * @param $key
     * @return static
     */
    public static function findByKey($key)
    {
        $db_read = Yii::$app->db;
        return Setting::find()->where(['skey' => $key])->one($db_read);
    }

    /**
     * 更新配置，如果不存在则创建
     * @param string $key
     * @param string $value
     * @param string $text
     * @return bool
     */
    public static function updateSetting($key, $value, $text='')
    {
        // if (!in_array($key, static::$keys)) return false;
        $setting = static::findByKey($key);
        if (!$setting) {
            $setting = new Setting();
        }
        $setting->skey = $key;
        $setting->svalue = $value;
        if($text){
            $setting->stext = $text;
        }
        return $setting->save();
    }

    

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }
}