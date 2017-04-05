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
     * 取配置信息
     * @param boolean $refresh 是否立即刷新
     * @return array
     */
    public static function read($refresh = false)
    {
        if ($refresh || !($res = \Lying::$maker->cache()->get('config'))) {
            $res = self::find()->asArray()->all();
            $res = array_combine(array_column($res, 'name'), array_column($res, 'value'));
            if (empty($res['cdn'])) {
                $res['cdn'] = $res['bucket'] . '.' . Endpoint::expoint($res['endpoint']);
            }
            \Lying::$maker->cache()->set('config', $res);
        }
        return $res;
    }
}
