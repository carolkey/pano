<?php
namespace util;

class Common
{
    /**
     * 返回随机字符串
     * @param integer $length 字符串长度
     * @return string 生成的随机字符串
     */
    public static function randomStr($length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        for ($str = '', $len = strlen($chars) - 1, $i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, $len), 1);
        }
        return $str;
    }
}
