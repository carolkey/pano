<fieldset class="layui-elem-field layui-field-title">
    <legend>系统探针</legend>
    <div class="layui-field-box">
        <table class="layui-table">
            <thead>
                <tr>
                    <th colspan="4">服务器参数</th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <td>服务器标识</td>
                    <td colspan="3"><?= php_uname(); ?></td>
                </tr>
                <tr>
                    <td>服务器系统</td>
                    <td><?= PHP_OS; ?></td>
                    <td>服务器语言</td>
                    <td><?= getenv("HTTP_ACCEPT_LANGUAGE"); ?></td>
                </tr>
                <tr>
                    <td>服务器引擎</td>
                    <td><?= $_SERVER['SERVER_SOFTWARE']; ?></td>
                    <td>站点根路径</td>
                    <td><?= $_SERVER['DOCUMENT_ROOT']; ?></td>
                </tr>
                <tr>
                    <td>服务器主机名</td>
                    <td><?= gethostname(); ?></td>
                    <td>管理员邮箱</td>
                    <td><?= $_SERVER['SERVER_ADMIN']; ?></td>
                </tr>
                <tr>
                    <td>服务器域名/IP地址</td>
                    <td><?= $_SERVER['SERVER_NAME']; ?>(<?= $_SERVER['SERVER_ADDR']; ?>)</td>
                    <td>服务器端口</td>
                    <td><?= $_SERVER['SERVER_PORT']; ?></td>
                </tr>
            </tbody>
        </table>

        <table class="layui-table">
            <thead>
                <tr>
                    <th colspan="10">PHP已编译模块</th>
                </tr> 
            </thead>
            <tbody>
                <?php
                $ml = get_loaded_extensions();
                $line = ceil(count($ml) / 10);
                ?>
                <?php for ($i = 0; $i < $line; $i++): ?>
                <tr>
                    <?php for ($n = 0; $n < 10; $n++): ?>
                    <td><?= array_shift($ml); ?></td>
                    <?php endfor; ?>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <table class="layui-table">
            <thead>
                <tr>
                    <th colspan="4">PHP相关参数</th>
                </tr> 
            </thead>
            <tbody>
                <?php
                function show_cfg($name)
                {
                    switch($result = get_cfg_var($name))
                    {
                        case 0:
                            return '<i class="layui-icon">&#x1006;</i>';
                            break;
                        case 1:
                            return '<i class="layui-icon">&#xe605;</i>';
                            break;
                        default:
                            return $result;
                            break;
                    }
                }
                ?>
                <tr>
                    <td>phpinfo</td>
                    <td><a href="<?= url('index', ['phpinfo'=>1]); ?>" target="_blank">PHPINFO</a></td>
                    <td>php_version</td>
                    <td><?= PHP_VERSION; ?></td>
                </tr>
                <tr>
                    <td>sapi</td>
                    <td><?= php_sapi_name(); ?></td>
                    <td>memory_limit</td>
                    <td><?= show_cfg('memory_limit'); ?></td>
                </tr>
                <tr>
                    <td>safe_mode</td>
                    <td><?= show_cfg('safe_mode'); ?></td>
                    <td>post_max_size</td>
                    <td><?= show_cfg('post_max_size'); ?></td>
                </tr>
                <tr>
                    <td>upload_max_filesize</td>
                    <td><?= show_cfg('upload_max_filesize'); ?></td>
                    <td>precision</td>
                    <td><?= show_cfg('precision'); ?></td>
                </tr>
                <tr>
                    <td>max_execution_time</td>
                    <td><?= show_cfg('max_execution_time'); ?>s</td>
                    <td>default_socket_timeout</td>
                    <td><?= show_cfg('default_socket_timeout'); ?>s</td>
                </tr>
                <tr>
                    <td>doc_root</td>
                    <td><?= show_cfg('doc_root'); ?></td>
                    <td>user_dir</td>
                    <td><?= show_cfg('user_dir'); ?></td>
                </tr>
                <tr>
                    <td>enable_dl</td>
                    <td><?= show_cfg('enable_dl'); ?></td>
                    <td>include_path</td>
                    <td><?= show_cfg('include_path'); ?></td>
                </tr>
                <tr>
                    <td>display_errors</td>
                    <td><?= show_cfg('display_errors'); ?></td>
                    <td>register_globals</td>
                    <td><?= show_cfg('register_globals'); ?></td>
                </tr>
                <tr>
                    <td>magic_quotes_gpc</td>
                    <td><?= show_cfg('magic_quotes_gpc'); ?></td>
                    <td>short_open_tag</td>
                    <td><?= show_cfg('short_open_tag'); ?></td>
                </tr>
                <tr>
                    <td>asp_tags</td>
                    <td><?= show_cfg('asp_tags'); ?></td>
                    <td>ignore_repeated_errors</td>
                    <td><?= show_cfg('ignore_repeated_errors'); ?></td>
                </tr>
                <tr>
                    <td>ignore_repeated_source</td>
                    <td><?= show_cfg('ignore_repeated_source'); ?></td>
                    <td>report_memleaks</td>
                    <td><?= show_cfg('report_memleaks'); ?></td>
                </tr>
                <tr>
                    <td>magic_quotes_runtime</td>
                    <td><?= show_cfg('magic_quotes_runtime'); ?></td>
                    <td>allow_url_fopen</td>
                    <td><?= show_cfg('allow_url_fopen'); ?></td>
                </tr>
                <tr>
                    <td>register_argc_argv</td>
                    <td><?= show_cfg('register_argc_argv'); ?></td>
                    <td>SMTP</td>
                    <td><?= show_cfg('SMTP'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</fieldset>