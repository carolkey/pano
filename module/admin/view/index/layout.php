<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="author" content="carol">
    <meta name="description" content="小黑屋-个人博客">
    <meta name="keywords" content="小黑屋,博客">
    <title>小黑屋</title>
    <link rel="stylesheet" href="http://oss.suyaqi.cn/static/layui1.0.9rls/css/layui.css">
    <link rel="stylesheet" href="/static/backend/css/global.css">
    <script src="http://oss.suyaqi.cn/static/layui1.0.9rls/layui.js"></script>
</head>
<body>
<!-- 顶部导航 -->
<header class="header">
    <h1 class="layui-hide">小黑屋</h1>
    <img class="header-logo" src="/static/common/image/logo.png" alt="LOGO">
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
                    <li><a href=""><i class="layui-icon">&#xe614;</i> 系统探针</a></li>
                    <li><a href=""><i class="layui-icon">&#xe614;</i> 站点设置</a></li>
                    <li><a href=""><i class="layui-icon">&#xe614;</i> 软件设置</a></li>
                    <li><a href=""><i class="layui-icon">&#xe614;</i> 存储设置</a></li>
                </ul>
            </div>
        </div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">项目管理</h2>
            <div class="layui-colla-content layui-show">
                <ul>
                    <li><a href=""><i class="layui-icon">&#xe62e;</i> 地主管理</a></li>
                    <li><a href=""><i class="layui-icon">&#xe62e;</i> 楼盘项目</a></li>
                    <li><a href=""><i class="layui-icon">&#xe62e;</i> 标签管理</a></li>
                </ul>
            </div>
        </div>
        <div class="layui-colla-item">
            <h2 class="layui-colla-title">素材管理</h2>
            <div class="layui-colla-content layui-show">
                <ul>
                    <li><a href=""><i class="layui-icon">&#xe61d;</i> 全景图片</a></li>
                    <li><a href=""><i class="layui-icon">&#xe61d;</i> 图片素材</a></li>
                    <li><a href=""><i class="layui-icon">&#xe61d;</i> 音频素材</a></li>
                </ul>
            </div>
        </div>
    </div>
</aside>
<!-- 内容容器 -->
<div class="container">
    <?= $container ?>
</div>

<footer class="footer">
    <p>Copyright © 2017 waaili.me | Powered by <a href="">Lying</a></p>
    <p>闽ICP备15011128号</p>
</footer>

<script>
    layui.use(['element', 'form', 'upload'], function(){
        layui.upload({
            url: '上传接口url'
            ,success: function(res){
                console.log(res); //上传成功返回值，必须为json格式
            }
        });
    });
</script>
</body>
</html>