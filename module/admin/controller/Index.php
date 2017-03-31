<?php
namespace module\admin\controller;

class Index extends ACL
{
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
}
