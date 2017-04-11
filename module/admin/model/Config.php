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
        try {
            $datas = [];
            foreach ($data as $name => $value) {
                $datas[] = [$name, trim($value), $type];
            }
            $res = self::find()->batchInsert(self::table(), ['name', 'value', 'type'], $datas, true);
            self::read(true);
            return $res;
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * 取配置信息
     * @param boolean $refresh 是否刷新缓存
     * @return array 返回配置数组
     */
    public static function read($refresh = false)
    {
        $cache = \Lying::$maker->cache();
        if ($refresh || !($res = $cache->get('config'))) {
            $res = self::find()->asArray()->all();
            $res = array_combine(array_column($res, 'name'), array_column($res, 'value'));
            if (empty($res['cdn'])) {
                $expoint = Endpoint::search($res['endpoint']);
                $res['cdn'] = $res['bucket'] . ".$expoint";
            }
            $cache->set('config', $res);
        }
        return $res;
    }
}
