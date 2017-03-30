<?php
namespace module\admin\controller;

use lying\base\Controller;

class Login extends Controller
{
    private $session;

    public function init()
    {
        $session = \Lying::$maker->session();
        if ($session->exists('login')) {
            $this->redirect('index/index');
        }
        $this->session = \Lying::$maker->session();
    }

    public function index()
    {

        return $this->render('index');
    }

    public function code()
    {
        $num1 = mt_rand(100, 999);
        $num2 = mt_rand(100, 999);
        $this->session['code'] = $num1 + $num2;
        $text = $num1 . ' + ' . $num2 . ' = ?';

        $image = imagecreatetruecolor(120, 36);
        $back_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 0, 0, 0);

        imagefilledrectangle($image, 0, 0, 120, 36, $back_color);
        imagestring($image, 4, 8, 8, $text, $text_color);

        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}
