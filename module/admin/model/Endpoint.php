<?php
namespace module\admin\model;

use lying\db\ActiveRecord;

class Endpoint extends ActiveRecord
{
    /**
     * 查找访问域名
     * @param integer $id enpoint ID
     * @param boolean $internal 是否为内网
     * @return mixed
     */
    public static function search($id, $internal = false)
    {
        return self::find()->select([$internal ? 'inpoint' : 'expoint'])->where(['id' => $id])->column();
    }
}
