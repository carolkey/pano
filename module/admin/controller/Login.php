<?php
namespace module\admin\controller;

use lying\base\Controller;
use module\admin\model\Adminer;
use module\admin\model\Config;

class Login extends Controller
{
    /**
     * @var \lying\service\Session
     */
    private $session;

    /**
     * 控制器初始化事件
     */
    public function beforeAction($action)
    {
        $session = \Lying::$maker->session();
        if ($session->exists('adminer') && $action != 'logout') {
            $this->redirect('setting/index');
        }
        $this->session = \Lying::$maker->session();
    }

    /**
     * 登陆页面
     * @return string
     */
    public function index()
    {
        if (\Lying::$maker->request()->isPost()) {
            if (post('code') !== (string)$this->session['code']) {
                $ret = ['stat' => 1, 'msg' => '验证码错误'];
            } elseif (!Adminer::login(post('account'), post('password'), post('code'))) {
                $ret = ['stat' => 2, 'msg' => '账号或者密码错误'];
            } else {
                unset($this->session['code']);
                $ret = ['stat' => 0, 'msg' => '登陆成功'];
            }
            return json_encode($ret);
        }
        return $this->render('index', Config::read());
    }

    /**
     * 退出登陆
     */
    public function logout()
    {
        if ($this->session->exists('adminer')) {
            $this->session->destroy();
            return $this->redirect('index/index');
        }
    }

    /**
     * 生成验证码
     */
    public function code()
    {
        $num1 = mt_rand(0, 99);
        $num2 = mt_rand(0, 99);
        $this->session['code'] = $num1 + $num2;
        $text = $num1 . ' + ' . $num2 . ' = ?';

        $image = imagecreatetruecolor(100, 36);
        $back_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 0, 0, 0);

        imagefilledrectangle($image, 0, 0, 100, 36, $back_color);
        imagestring($image, 4, 6, 8, $text, $text_color);

        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}
