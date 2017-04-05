<?php
namespace module\admin\model;

use lying\db\ActiveRecord;

class Endpoint extends ActiveRecord
{
    public static function expoint($id)
    {
        return self::find()->select(['expoint'])->where(['id' => $id])->column();
    }
}
