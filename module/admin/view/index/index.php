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
                    <td>服务器引擎</td>
                    <td><?= getenv('SERVER_SOFTWARE'); ?></td>
                </tr>
                <tr>
                    <td>服务器主机</td>
                    <td><?= gethostname(); ?></td>
                    <td>站点根路径</td>
                    <td><?= getenv('DOCUMENT_ROOT'); ?></td>
                </tr>
                <tr>
                    <td>服务器域名</td>
                    <td><?= getenv('SERVER_NAME'); ?>:<?= getenv('SERVER_PORT'); ?></td>
                    <td>服务器地址</td>
                    <td><?= getenv('SERVER_ADDR'); ?></td>
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
                <?php for ($i = 0, $m = get_loaded_extensions(), $line = ceil(count($m) / 10); $i < $line; $i++): ?>
                <tr>
                    <?php for ($n = 0; $n < 10; $n++): ?>
                    <td><?= array_shift($m); ?></td>
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
                <tr>
                    <td>php_user</td>
                    <td><?= get_current_user(); ?></td>
                    <td>php_user_gid</td>
                    <td><?= getmygid(); ?></td>
                </tr>
                <tr>
                    <td>php_user_uid</td>
                    <td><?= getmyuid(); ?></td>
                    <td>php_pid</td>
                    <td><?= getmypid(); ?></td>
                </tr>
                <tr>
                    <td>phpinfo</td>
                    <td><a href="<?= url('index', ['phpinfo'=>1]); ?>" target="_blank">点击查看</a></td>
                    <td>php_ini_loaded_file</td>
                    <td><?= php_ini_loaded_file(); ?></td>
                </tr>
                <tr>
                    <td>zend_version</td>
                    <td><?= zend_version(); ?></td>
                    <td>php_version</td>
                    <td><?= PHP_VERSION; ?></td>
                </tr>
                <tr>
                    <td>sapi</td>
                    <td><?= PHP_SAPI; ?></td>
                    <td>precision</td>
                    <td><?= $show('precision'); ?></td>
                </tr>
                <tr>
                    <td>php_int_max</td>
                    <td><?= PHP_INT_MAX ?></td>
                    <td>php_int_size</td>
                    <td><?= PHP_INT_SIZE ?></td>
                </tr>
                <tr>
                    <td>default_include_path</td>
                    <td><?= DEFAULT_INCLUDE_PATH ?></td>
                    <td>php_extension_dir</td>
                    <td><?= PHP_EXTENSION_DIR ?></td>
                </tr>
                <tr>
                    <td>php_bindir</td>
                    <td><?= PHP_BINDIR ?></td>
                    <td>php_libdir</td>
                    <td><?= PHP_LIBDIR ?></td>
                </tr>
                <tr>
                    <td>php_config_file_path</td>
                    <td><?= PHP_CONFIG_FILE_PATH; ?></td>
                    <td>memory_limit</td>
                    <td><?= $show('memory_limit'); ?></td>
                </tr>
                <tr>
                    <td>post_max_size</td>
                    <td><?= $show('post_max_size'); ?></td>
                    <td>upload_max_filesize</td>
                    <td><?= $show('upload_max_filesize'); ?></td>
                </tr>
                <tr>
                    <td>max_execution_time</td>
                    <td><?= $show('max_execution_time'); ?>s</td>
                    <td>default_socket_timeout</td>
                    <td><?= $show('default_socket_timeout'); ?>s</td>
                </tr>
                <tr>
                    <td>enable_dl</td>
                    <td><?= $show('enable_dl'); ?></td>
                    <td>include_path</td>
                    <td><?= $show('include_path'); ?></td>
                </tr>
                <tr>
                    <td>display_errors</td>
                    <td><?= $show('display_errors'); ?></td>
                    <td>register_globals</td>
                    <td><?= $show('register_globals'); ?></td>
                </tr>
                <tr>
                    <td>magic_quotes_gpc</td>
                    <td><?= $show('magic_quotes_gpc'); ?></td>
                    <td>magic_quotes_runtime</td>
                    <td><?= $show('magic_quotes_runtime'); ?></td>
                </tr>
                <tr>
                    <td>short_open_tag</td>
                    <td><?= $show('short_open_tag'); ?></td>
                    <td>asp_tags</td>
                    <td><?= $show('asp_tags'); ?></td>

                </tr>
                <tr>
                    <td>ignore_repeated_source</td>
                    <td><?= $show('ignore_repeated_source'); ?></td>
                    <td>ignore_repeated_errors</td>
                    <td><?= $show('ignore_repeated_errors'); ?></td>
                </tr>
                <tr>
                    <td>report_memleaks</td>
                    <td><?= $show('report_memleaks'); ?></td>
                    <td>allow_url_fopen</td>
                    <td><?= $show('allow_url_fopen'); ?></td>
                </tr>
                <tr>
                    <td>register_argc_argv</td>
                    <td><?= $show('register_argc_argv'); ?></td>
                    <td>safe_mode</td>
                    <td><?= $show('safe_mode'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</fieldset>