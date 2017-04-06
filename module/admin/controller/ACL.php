<?php
namespace module\admin\controller;

use lying\base\Controller;
use module\admin\model\Config;

class ACL extends Controller
{
    protected $layout = 'layout/layout';

    protected function init()
    {
        $session = \Lying::$maker->session();
        if ($session->exists('adminer')) {
            $this->subparams = Config::read();
        } else {
            $this->redirect('login/index');
        }
    }
}
