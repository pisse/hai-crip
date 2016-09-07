<?php
/**
 * Created by JohnnyLin.
 * User: JohnnyLin
 * Date: 2015/06/21
 */

namespace common\helpers;

use Yii;

class MailHelper
{
    const SUBJECT_YGB="员工";

    const MODLE_CAPTCHA=1;

    public static $modle =[

        self::MODLE_CAPTCHA=>'验证码',
    ];

    public static function sendMail($subject="员工", $content, $to) {

        $ret = \Yii::$app->mailer->compose()
            ->setTo( $to )
            ->setSubject( $subject )
            ->setTextBody( '验证码：'.$content['code'] )
            ->send();

        Yii::info( \sprintf('[%s]邮件发送 %s: %s', date('Y-m-d H:i:s'), $to, ($ret ? '成功' : '失败')) );

        return $ret;
    }

}
