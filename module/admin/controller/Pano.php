<?php
namespace module\admin\controller;

use module\admin\model\Endpoint;
use module\admin\model\Panoimg;
use util\Common;
use util\Krpano;
use util\Oss;

class Pano extends ACL
{

    public function publish()
    {

        return $this->render('publish');
    }

    /**
     * 获取OSS签名
     * @return string
     */
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

    /**
     * 用来处理上传的全景图片的，切图+上传
     * @return string
     */
    public function process()
    {
        if ($images = post('images')) {
            set_time_limit(0);
            ignore_user_abort(true);

            $res = Common::operation($images, new Oss(
                $this->subparams['key_id'],
                $this->subparams['key_secret'],
                Endpoint::search($this->subparams['endpoint'], $this->subparams['internal']),
                $this->subparams['bucket']
            ), new Krpano(
                $this->subparams['os']
            ));
            $res = $res ? ['stat' => 0, 'msg' => '切图成功'] : ['stat' => 2, 'msg' => '切图失败'];
        } else {
            $res = ['stat' => 1, 'msg' => '接收数据错误'];
        }
        return json_encode($res);
    }

    /**
     * 显示全景图列表
     * @param integer $page 当前页数
     * @return string
     */
    public function panolist($page = 1)
    {
        list($page, $pages, $list) = Panoimg::findPage('10', $page);
        $host = \Lying::$maker->request()->scheme() . '://' . \Lying::$maker->request()->host() . '/vtour/';
        return $this->render('panolist', ['curr'=>$page, 'pages'=>$pages, 'list'=>$list, 'host'=>$host]);
    }

    /**
     * 更新名字
     * @return string
     */
    public function changeName()
    {
        $name = post('name');
        $uuid = post('uuid');
        $res = Panoimg::find()->update(Panoimg::table(), ['filename'=>$name], ['uuid'=>$uuid]);
        return json_encode(false === $res ? ['stat'=>1, 'msg'=>'更新失败d'] : ['stat'=>0, 'msg'=>'更新成功']);
    }
}
