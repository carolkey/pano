<?php
namespace module\admin\model;

class Oss
{
    /**
     * 获取签名
     * @param string $dir 要上传的路径前缀，如user/name/
     * @return string 返回签名信息
     */
    public static function signature($dir)
    {
        $config = \Lying::$maker->config()->read('config');
        //设置该policy超时时间是10s，即这个policy过了这个有效时间，将不能访问
        $expiration = self::gmt_iso8601(time() + 1200);
        //最大文件大小，用户可以自己设置
        $conditions[] = ['content-length-range', 0, 1572864000];
        //表示用户上传的数据，必须是以$dir开始
        $conditions[] = ['starts-with', '$key', $dir];

        $response['accessid'] = $config['key_id'];
        $response['host'] = $config['cdn'];
        $response['policy'] = base64_encode(json_encode(['expiration' => $expiration, 'conditions' => $conditions]));
        $response['signature'] = base64_encode(hash_hmac('sha1', $response['policy'], $config['key_secret'], true));
        $response['dir'] = $dir;
        return json_encode($response);
    }

    /**
     * 设置过期时间
     * @param integer $time
     * @return string
     */
    private static function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
}
