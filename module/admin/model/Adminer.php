<?php
namespace module\admin\model;

use lying\db\ActiveRecord;

class Adminer extends ActiveRecord
{
    /**
     * 校验用户名密码
     * @param string $account
     * @param string $password
     * @param string $code
     * @return bool
     */
    public static function login($account, $password, $code)
    {
        if ($adminer = self::findOne(['account' => $account])) {
            if (hash_hmac('sha256', $adminer->password, $code) === $password) {
                \Lying::$maker->session()->set('adminer', [
                    'id' => $adminer->id,
                    'account' => $adminer->account,
                ]);
                return true;
            }
        }
        return false;
    }
}
