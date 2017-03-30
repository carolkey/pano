<?php
namespace module\admin\controller;

use lying\base\Controller;

class ACL extends Controller
{
    protected function init()
    {
        $session = \Lying::$maker->session();
        if (!$session->exists('adminer')) {
            $this->redirect('login/index');
        }
    }
}
