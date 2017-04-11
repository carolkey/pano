<?php
namespace module\admin\controller;

use lying\base\Controller;
use module\admin\model\Config;
use module\admin\model\Panoimg;

class Vtour extends Controller
{

    public function index($uuid)
    {
        $name = Panoimg::find()->select(['filename'])->where(['uuid'=>$uuid])->column();
        return $this->render('index', ['uuid'=>$uuid, 'name'=>$name]);
    }

    public function xml($xmluuid)
    {
        $uuid = substr($xmluuid, 3);
        $conf = Config::read();
        $url = 'http://' . $conf['cdn'] . '/panos/' . $uuid;
        return $this->render('xml', ['url'=>$url, 'uuid'=>$uuid]);
    }
}
