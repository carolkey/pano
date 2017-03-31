<?php
namespace module\admin\controller;

class Config extends ACL
{

    public function web()
    {
        if (\Lying::$maker->request()->isPost()) {
            $res = \module\admin\model\Config::modify(post(), 'web');
            return json_encode(false === $res ? ['stat'=>1, 'msg'=>'更新失败'] : ['stat'=>0, 'msg'=>'更新成功']);
        }
        return $this->render('web', $this->subparams);
    }


}
