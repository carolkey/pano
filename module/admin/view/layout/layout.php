<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="author" content="carol">
    <meta name="keywords" content="<?= $keywords; ?>">
    <meta name="description" content="<?= $description; ?>">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/backend/css/global.css">
    <script src="/static/layui/layui.js"></script>
</head>
<body>
<!-- 顶部导航 -->
<header class="header">
    <h1 class="layui-hide"><?= $title; ?></h1>
    <img class="header-logo" src="<?= $logo; ?>" alt="LOGO">
    <nav class="header-nav">
        <h2 class="layui-hide">导航</h2>
        <ul>
            <li class="header-nav-on"><a href="">首页</a></li>
            <li><a href="">语录</a></li>
            <li><a href="">相册</a></li>
            <li><a href="">归档</a></li>
            <li><a href="">关于</a></li>
        </ul>
    </nav>
</header>
<!-- 侧边菜单 -->
<aside class="aside">
    <h2 class="layui-hide">菜单</h2>
    <div class="layui-collapse">
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">系统设置</h2>
            <div class="layui-colla-content layui-show">
                <ul>
                    <li><a href="<?= url('setting/index'); ?>"><i class="layui-icon">&#xe62c;</i> 系统探针</a></li>
                    <li><a href="<?= url('setting/web'); ?>"><i class="layui-icon">&#xe631;</i> 站点设置</a></li>
                    <li><a href="<?= url('setting/krpano'); ?>"><i class="layui-icon">&#xe628;</i> 软件设置</a></li>
                    <li><a href="<?= url('setting/oss'); ?>"><i class="layui-icon">&#xe624;</i> 存储设置</a></li>
                </ul>
            </div>
        </div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">项目管理</h2>
            <div class="layui-colla-content layui-show">
                <ul>
                    <li><a href="javascript:;"><i class="layui-icon">&#xe62e;</i> 楼盘项目</a></li>
                    <li><a href="javascript:;"><i class="layui-icon">&#xe609;</i> 标签管理</a></li>
                </ul>
            </div>
        </div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">素材管理</h2>
            <div class="layui-colla-content layui-show">
                <ul>
                    <li><a href="<?= url('pano/publish'); ?>"><i class="layui-icon">&#xe64e;</i> 发布全景</a></li>
                    <li><a href="<?= url('pano/panolist'); ?>"><i class="layui-icon">&#xe634;</i> 全景图片</a></li>
                    <li><a href="javascript:;"><i class="layui-icon">&#xe60d;</i> 图片素材</a></li>
                    <li><a href="javascript:;"><i class="layui-icon">&#xe645;</i> 音频素材</a></li>
                </ul>
            </div>
        </div>
    </div>
</aside>
<!-- 内容容器 -->
<div class="container">
    <?= $container; ?>
</div>
<!-- 页脚 -->
<footer class="footer">
    <p><?= $copyright; ?></p>
    <p><?= $icp; ?></p>
</footer>
</body>
<!-- 脚本 -->
<script>
    layui.use(['element'], function(){

    });
</script>
</html>