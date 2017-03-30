<?php
namespace module\admin\controller;

class Index extends ACL
{
    public $layout = 'layout';
    
    public function index()
    {

        return $this->render('index');
    }
}
