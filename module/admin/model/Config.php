<?php
namespace module\admin\model;

use lying\db\ActiveRecord;

class Config extends ActiveRecord
{
    /**
     * 更新配置
     * @param array $data POST数组
     * @param string $type 配置类型
     * @return boolean|integer 成功返回行数，失败返回false
     */
    public static function modify($data, $type)
    {
        $datas = [];
        foreach ($data as $name => $value) {
            $datas[] = [$name, $value, $type];
        }
        $res = self::find()->batchInsert(self::table(), ['name', 'value', 'type'], $datas, true);
        self::read(true);
        return $res;
    }

    /**
     * 取站点信息
     * @param boolean $refresh 是否立即刷新
     * @return array
     */
    public static function read($refresh = false)
    {
        $res = \Lying::$maker->cache()->get('config');
        if ($refresh || !$res) {
            $res = self::find()->asArray()->all();
            $res = array_combine(array_column($res, 'name'), array_column($res, 'value'));
            \Lying::$maker->cache()->set('config', $res);
        }
        return $res;
    }
}
