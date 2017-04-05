<?php
namespace module\admin\controller;

use module\admin\model\Endpoint;
use module\admin\model\Krpano;

class Config extends ACL
{
    /**
     * 站点设置
     * @return string
     */
    public function web()
    {
        if (\Lying::$maker->request()->isPost()) {
            $res = \module\admin\model\Config::modify(post(), 'web');
            $res = false === $res ? ['stat' =>1 , 'msg' => '更新失败'] : ['stat' => 0, 'msg' => '更新成功'];
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
        if (isset($_FILES)) {
            $file = array_shift($_FILES);
            $type = [1 => '.gif', 2 => '.jpg', 3 => '.png'];
            $path = WEB_ROOT . '/static/common/image/logo';
            if ($fileinfo = @getimagesize($file['tmp_name'])) {
                if (!isset($type[$fileinfo[2]])) {
                    return json_encode(['stat' => 1, 'msg' => '不支持的图片类型']);
                } elseif ($fileinfo[0] != 180 || $fileinfo[1] != 60) {
                    return json_encode(['stat' => 2, 'msg' => '图片尺寸应为180x60']);
                } elseif(@move_uploaded_file($file['tmp_name'], $path . $type[$fileinfo[2]])) {
                    return json_encode(['stat' => 0, 'msg' => '上传成功']);
                }
            }
        }
        return json_encode(['stat' => 3, 'msg' => '上传失败']);
    }

    /**
     * 配置krpano
     * @return string
     */
    public function krpano()
    {
        if (\Lying::$maker->request()->isPost()) {
            $res = \module\admin\model\Config::modify(post(), 'krpano');
            if (false === $res) {
                return json_encode(['stat' => 1, 'msg' => '更新失败']);
            } else {
                Krpano::register($output1);
                Krpano::showRegister($output2);
                return json_encode(['stat' => 0, 'msg' => '更新成功，注册结果：' . $output1, 'info' => $output2]);
            }
        }
        Krpano::showRegister($output);
        return $this->render('krpano', $this->subparams + ['register' => $output]);
    }

    /**
     * 配置云存储
     * @return string
     */
    public function oss()
    {
        if (\Lying::$maker->request()->isPost()) {
            $res = \module\admin\model\Config::modify(post(), 'oss');
            $res = false === $res ? ['stat' => 1, 'msg' => '更新失败'] : ['stat' => 0, 'msg' => '更新成功'];
            return json_encode($res);
        }
        $endpointList = Endpoint::find()->asArray()->all();
        return $this->render('oss', $this->subparams + ['endpointList' => $endpointList]);
    }
}
