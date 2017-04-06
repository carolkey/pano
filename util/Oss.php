<?php
namespace util;

use OSS\OssClient;

class Oss {
    /**
     * @var string accessKeyId
     */
    private $key;

    /**
     * @var string accessKeySecret
     */
    private $secret;

    /**
     * @var string endpoint
     */
    private $endpoint;

    /**
     * @var string bucket
     */
    private $bucket;

    /**
     * @var OssClient|null
     */
    private $cilent;

    /**
     * Oss constructor.
     * @param string $key accessKeyId
     * @param string $secret accessKeySecret
     * @param string $endpoint endpoint
     * @param string $bucket bucket
     */
    public function __construct($key, $secret, $endpoint, $bucket)
    {
        $this->key = trim($key);
        $this->secret = trim($secret);
        $this->endpoint = 'http://' . preg_replace('/^https?:\/\/|\/$/', '', trim($endpoint));
        $this->bucket = $bucket;
    }

    /**
     * 格式化过期时间
     * @param integer $time 过期时间戳
     * @return string 返回格式化后的字符串
     */
    private function gmt_iso8601($time) {
        $dtStr = date('c', $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration . 'Z';
    }

    /**
     * 获取policy签名
     * @param string|boolean $dir 指定用户上传的目录前缀，开头不能是'/'且末尾必须是'/'，如'usr/img/'
     * @return string 返回签名后的字符串
     */
    public function signature($dir)
    {
        //设置该policy超时时间是1200s，即这个policy过了这个有效时间，将不能访问
        $expiration = $this->gmt_iso8601(time() + 1200);
        //最大文件大小，用户可以自己设置
        $conditions[] = ['content-length-range', 0, 1572864000];
        //表示用户上传的数据，必须是以$dir开始
        $conditions[] = ['starts-with', '$key', $dir];

        $response['accessKeyId'] = $this->key;
        $response['host'] = $this->endpoint;
        $response['policy'] = base64_encode(json_encode(['expiration' => $expiration, 'conditions' => $conditions]));
        $response['signature'] = base64_encode(hash_hmac('sha1', $response['policy'], $this->secret, true));
        $response['prefix'] = $dir;
        return json_encode($response);
    }

    /**
     * 返回OssClient实例，失败返回false
     * @return bool|OssClient
     */
    private function client()
    {
        if ($this->cilent === null) {
            try {
                $this->cilent = new OssClient($this->key, $this->secret, $this->endpoint);
            } catch (OssException $e) {
                $this->cilent = false;
            }
        }
        return $this->cilent;
    }

    /**
     * 下载文件到本地
     * @param string $obj oss上的对象
     * @param string $file 本地文件
     * @return boolean 成功返回true，失败返回false
     */
    public function downloadFile($obj, $file)
    {
        try{
            $this->client()->getObject($this->bucket, $obj, [OssClient::OSS_FILE_DOWNLOAD => $file]);
            return true;
        } catch(OssException $e) {
            return false;
        }
    }
}