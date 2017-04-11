<?php
namespace util;

class Krpano
{
    /**
     * @var integer 操作系统类型
     */
    private $os;

    /**
     * Krpano constructor.
     * @param integer $os 操作系统类型，1、win32，2、win64，3、linux32，linux64
     */
    public function __construct($os = 2)
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
    private function toUtf8($str)
    {
        $encode = mb_detect_encoding($str, ['GBK', 'GB2312', 'UTF-8'], true);
        return mb_convert_encoding($str, 'UTF-8', $encode);
    }

    /**
     * 把路径中的/转换成\，或者把\转换成/
     * @param string $path 要转换的路径
     * @return mixed
     */
    private function convertPath($path)
    {
        return str_replace($this->os < 3 ? '/' : '\\', DIRECTORY_SEPARATOR, $path);
    }

    /**
     * 执行命令
     * @param string $command 要执行的命令
     * @param string $output 执行输出信息
     * @return integer 命令执行成功返回0，失败返回错误码
     */
    private function exec($command, &$output = null)
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
        $command = $this->convertPath($this->createCommand()) . "register $code";
        return $this->exec($command, $output);
    }

    /**
     * 获取注册信息
     * @param string $output 执行输出的信息
     * @return integer 执行成功返回0，失败返回错误码
     */
    public function registerInfo(&$output)
    {
        $command = $this->convertPath($this->createCommand()) . 'register show';
        return $this->exec($command, $output);
    }

    /**
     * 生成全景图
     * @param array $files 绝对路径的文件数组
     * @return integer 执行成功返回0，失败返回错误码
     */
    public function makepano($files)
    {
        $command = $this->createCommand() . 'makepano templates/vtour-normal.config ' . implode(' ', $files);
        return $this->exec($this->convertPath($command));
    }

    /**
     * 删除路径或者文件，为了安全起见，只能删除ROOT路径下的目录和文件
     * @param string $path 要删除的路径或者文件
     * @return integer 执行成功返回0，失败返回错误码
     */
    public function rm($path)
    {
        if (0 === strncmp(ROOT, $path, strlen(ROOT))) {
            $command = ($this->os < 3 ? 'rd/s/q ' : 'rm -rf') . $this->convertPath($path);
            return $this->exec($command);
        }
    }
}
