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

    /**
     * 切图
     * @param array $images 上产页面POST的数组
     * @param Oss $oss
     * @param Krpano $krpano
     * @return boolean 成功返回true，失败返回false
     */
    public static function operation($images, Oss $oss, Krpano $krpano)
    {
        $result = false;
        $tmpDir = DIR_RUNTIME . '/pano/' . date('YmdHis') . self::randomStr(5) . '/';
        if (mkdir($tmpDir, 0777, true)) {
            //下载源文件到本地缓存路径
            foreach ($images as $img) {
                $uuid = self::randomStr(16);
                $local = $tmpDir . $uuid . '.jpg';
                if ($oss->downloadFile($img['objname'], $local)) {
                    $make[] = $local;
                    $succ[] = [
                        'filename' => preg_replace('/\.jpg$/i', '', $img['filename']),
                        'objname' => $img['objname'],
                        'source' => $img['host'] . '/' . $img['objname'],
                        'thumb' => $img['host'] . '/panos/' . $uuid . '/thumb.jpg',
                        'uuid' => $uuid,
                    ];
                }
            }
            //切图并上传
            if (isset($make) && 0 === $krpano->makepano($make)) {
                if ($oss->uploadDir('panos/', $tmpDir . 'vtour/panos/')) {
                    $db = \Lying::$maker->db();
                    $db->beginTransaction();
                    try {
                        $db->createQuery()->batchInsert('panoimg', [
                            'filename',
                            'objname',
                            'source',
                            'thumb',
                            'uuid',
                        ], $succ);
                        $db->commit();
                        $result = true;
                    } catch(\Exception $e) {
                        $db->rollBack();
                    }
                }
            }
            //删除缓存目录
            $krpano->rm($tmpDir);
        }
        return $result;
    }
}
