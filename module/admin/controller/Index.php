<?php
namespace module\admin\controller;

class Index extends ACL
{
    public $layout = 'layout';
    
    public function index($phpinfo = false)
    {
        return $phpinfo ? !phpinfo() : $this->render('index');
    }
}
