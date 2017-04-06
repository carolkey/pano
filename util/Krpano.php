<?php
namespace util;

class Krpano
{

    private $os;

    private $code;

    /**
     * Krpano constructor.
     * @param $os 操作系统类型，1、win32，2、win64，3、linux32，linux64
     */
    public function __construct($os)
    {
        $this->os = $os;
    }

    /**
     * 创建命令前缀
     * @return string
     */
    private function createCommand()
    {
        $command = ROOT . '/krpano';
        switch ($this->os) {
            case 1:
                $command .= '/krpano-win/krpanotools32.exe ';
                break;
            case 2:
                $command .= '/krpano-win/krpanotools64.exe ';
                break;
            case 3:
                $command .= '/krpano-l32/krpanotools ';
                break;
            case 4:
                $command .= '/krpano-l64/krpanotools ';
                break;
            default:
                $command .= '/krpano-win/krpanotools64.exe ';
        }
        return $command;
    }

    /**
     * 未知编码的字符串尝试转换为UTF-8
     * @param string $str 要转换的字符串
     * @return string 转换后的字符串
     */
    public function toUtf8($str)
    {
        $encode = mb_detect_encoding($str, ['GBK', 'GB2312', 'UTF-8'], true);
        return mb_convert_encoding($str, 'UTF-8', $encode);
    }

    /**
     * 执行命令
     * @param string $command 要执行的命令
     * @param string $output 执行输出信息
     * @return integer 命令执行成功返回0，失败返回错误码
     */
    public function exec($command, &$output)
    {
        exec($command, $output, $stat);
        $output = $this->toUtf8(implode("\n", $output));
        return $stat;
    }

    /**
     * 获取注册信息
     * @param string $code 注册码
     * @param string $output 执行输出的信息
     * @return integer 执行成功返回0，失败返回错误码
     */
    public function register($code, &$output)
    {
        $command = $this->createCommand() . "register $code";
        return $this->exec($command, $output);
    }

    /**
     * 获取注册信息
     * @param string $output 执行输出的信息
     * @return integer 执行成功返回0，失败返回错误码
     */
    public function registerInfo(&$output)
    {
        $command = $this->createCommand() . 'register show';
        return $this->exec($command, $output);
    }




}
