<?php
namespace module\admin\model;

class Krpano
{
    /**
     * 根据操作系统生成命令
     * @return string
     */
    private static function createCommand()
    {
        $command = ROOT . '/krpano';
        switch (\Lying::$maker->config()->read('config', 'os')) {
            case 1:
                $command .= '/krpano-win/krpanotools32.exe';
                break;
            case 2:
                $command .= '/krpano-win/krpanotools64.exe';
                break;
            case 3:
                $command .= '/krpano-l32/krpanotools';
                break;
            case 4:
                $command .= '/krpano-l64/krpanotools';
                break;
        }
        return $command;
    }

    /**
     * 转换字符串编码为UTF-8
     * @param string $str 要转换的字符串
     * @return string 转换后的字符串
     */
    private static function convert($str)
    {
        $encode = mb_detect_encoding($str, ['GBK', 'GB2312', 'UTF-8'], true);
        return mb_convert_encoding($str, 'UTF-8', $encode);
    }

    /**
     * 执行命令
     * @param string $command 要执行的命令
     * @param string $output 执行输出信息
     * @return integer 命令执行成功返回0,失败返回错误码
     */
    private static function exec($command, &$output)
    {
        exec($command, $output, $stat);
        $output = self::convert(implode("\n", $output));
        return $stat;
    }

    /**
     * 获取注册信息
     * @param string $output 执行输出的信息
     * @return int 执行成功返回0,失败返回错误码
     */
    public static function register(&$output)
    {
        $command = self::createCommand() . ' register ' . \Lying::$maker->config()->read('config', 'code');
        return self::exec($command, $output);
    }

    /**
     * 获取注册信息
     * @param string $output 执行输出的信息
     * @return integer 执行成功返回0,失败返回错误码
     */
    public static function showRegister(&$output)
    {
        $command = self::createCommand() . ' register show';
        return self::exec($command, $output);
    }
}
