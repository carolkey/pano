<?php
namespace module\admin\controller;

use module\admin\model\Config;
use module\admin\model\Endpoint;
use util\Krpano;

class Setting extends ACL
{
    /**
     * 系统探针
     * @param bool $phpinfo 是否显示phpinfo
     * @return bool|string
     */
    public function index($phpinfo = false)
    {
        return $phpinfo ? !phpinfo() : $this->render('index', [
            'show' => function ($name) {
                if (empty($result = get_cfg_var($name))) {
                    return '<i class="layui-icon">&#x1006;</i>';
                } elseif ($result === '1') {
                    return '<i class="layui-icon">&#xe605;</i>';
                } else {
                    return $result;
                }
            },
        ]);
    }

    /**
     * 站点设置
     * @return string
     */
    public function web()
    {
        if (\Lying::$maker->request()->isPost()) {
            if (false === $res = Config::modify(post(), 'web')) {
                $res = ['stat' => 1, 'msg' => '更新失败'];
            } else {
                $res = ['stat' => 0, 'msg' => '更新成功'];
            }
            return json_encode($res);
        }
        return $this->render('web', $this->subparams);
    }

    /**
     * 上传LOGO
     * @return string
     */
    public function logo()
    {
        if (isset($_FILES) && $file = $_FILES['logo']) {
            $type = [1 => '.gif', 2 => '.jpg', 3 => '.png'];
            $path = '/static/common/image/logo';
            try {
                $fileinfo = getimagesize($file['tmp_name']);
                if (!isset($type[$fileinfo[2]])) {
                    $res = ['stat' => 1, 'msg' => '不支持的图片类型'];
                } elseif ($fileinfo[0] != 180 || $fileinfo[1] != 60) {
                    $res = ['stat' => 2, 'msg' => '图片尺寸应为180x60'];
                } elseif (move_uploaded_file($file['tmp_name'], WEB_ROOT . $path . $type[$fileinfo[2]]) && false !== Config::modify(['logo' => $path . $type[$fileinfo[2]]], 'web')) {
                    $res = ['stat' => 0, 'msg' => '上传成功'];
                } else {
                    $res = ['stat' => 3, 'msg' => '上传失败'];
                }
            } catch(\Exception $e) {
                $res = ['stat' => 4, 'msg' => '上传失败' . $e->getMessage()];
            }
        }
        return json_encode(isset($res) ? $res : ['stat' => 5, 'msg' => '上传失败']);
    }

    /**
     * 配置krpano
     * @return string
     */
    public function krpano()
    {
        $krpano = new Krpano($this->subparams['os']);
        if (\Lying::$maker->request()->isPost()) {
            $res = Config::modify(post(), 'krpano');
            if (false === $res) {
                $res = ['stat' => 1, 'msg' => '更新失败'];
            } else {
                $krpano->register($this->subparams['code'], $output1);
                $krpano->registerInfo($output2);
                $res = ['stat' => 0, 'msg' => '更新成功，注册结果：' . $output1, 'info' => $output2];
            }
            return json_encode($res);
        }
        $krpano->registerInfo($output);
        return $this->render('krpano', $this->subparams + ['register' => $output]);
    }

    /**
     * 配置云存储
     * @return string
     */
    public function oss()
    {
        if (\Lying::$maker->request()->isPost()) {
            $res = Config::modify(post(), 'oss');
            $res = false === $res ? ['stat' => 1, 'msg' => '更新失败'] : ['stat' => 0, 'msg' => '更新成功'];
            return json_encode($res);
        }
        $endpointList = Endpoint::find()->asArray()->all();
        return $this->render('oss', $this->subparams + ['endpointList' => $endpointList]);
    }
}
