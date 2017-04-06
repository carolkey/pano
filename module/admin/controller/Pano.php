<?php
namespace module\admin\controller;

use module\admin\model\Endpoint;
use module\admin\model\Project;
use util\Common;
use util\Oss;

class Pano extends ACL
{

    public function building()
    {
        return $this->render('building', $this->subparams);
    }

    public function tags()
    {
        return $this->render('tags', $this->subparams);
    }


    public function publish()
    {

        return $this->render('publish');
    }

    public function signature()
    {
        $oss = new Oss(
            $this->subparams['key_id'],
            $this->subparams['key_secret'],
            $this->subparams['cdn'],
            $this->subparams['bucket']
        );
        return $oss->signature('sourceimg/');
    }

    public function process()
    {
        if (\Lying::$maker->request()->isPost() && $images = post('images')) {
            $tmpDir = DIR_RUNTIME . '/pano/' . Common::randomStr(5);
            if (mkdir($tmpDir)) {
                $endpoint = Endpoint::find()
                    ->select([$this->subparams['internal'] ? 'inpoint' : 'expoint'])
                    ->where(['id' => $this->subparams['endpoint']])
                    ->column();

                $oss = new Oss(
                    $this->subparams['key_id'],
                    $this->subparams['key_secret'],
                    $endpoint,
                    $this->subparams['bucket']
                );

                foreach ($images as $img) {
                    $pid = Common::randomStr(16);
                    if ($oss->downloadFile($img['key'], $tmpDir)) {

                    }
                }


            } else {
                $res = ['stat' => 2, 'msg' => '创建临时文件夹失败'];
            }






            $res = ['stat' => 0, 'msg' => '全景图处理成功'];
        } else {
            $res = ['stat' => 1, 'msg' => '接收数据错误'];
        }
        return json_encode($res);
    }
}
