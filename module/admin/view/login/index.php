<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="author" content="carol">
	<meta name="description" content="小黑屋-个人博客">
	<meta name="keywords" content="小黑屋,博客">
	<title>小黑屋-登录</title>

	<link rel="stylesheet" href="http://oss.suyaqi.cn/static/layui1.0.9rls/css/layui.css">

	<style>
		.container {
			box-sizing: border-box;
			position: fixed;
			width: 400px;
			height: 300px;
			top: 50%;
			left: 50%;
			margin-top: -150px;
			margin-left: -200px;
			background-color: #fff;
			padding: 55px 30px;
		}
		#code {
			position: absolute;
			top: 1px;
			right: 1px;
			height: 36px;
			width: 100px;
			border: none;
			outline: none;
			cursor: pointer;
		}
	</style>
</head>
<body style="background-color: #f1f1f1;">
	<div class="container">
		<form class="layui-form layui-form-pane" method="post">
			<div class="layui-form-item">
				<label class="layui-form-label">账　号</label>
				<div class="layui-input-block">
					<input type="text" name="account" placeholder="请输入账号" autocomplete="off" class="layui-input" lay-verify="account">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">密　码</label>
				<div class="layui-input-block">
					<input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input" lay-verify="password">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">验证码</label>
				<div class="layui-input-block">
					<input type="text" name="code" placeholder="请输入验证码" autocomplete="off" class="layui-input" lay-verify="code">
					<img id="code" src="<?= url('login/code') ?>" alt="code">
				</div>
			</div>
			<div class="layui-form-item">
				<button class="layui-btn" lay-submit lay-filter="login" style="width: 100%;">立 即 登 录</button>
			</div>
		</form>
	</div>
</body>
<script src="http://oss.suyaqi.cn/static/layui1.0.9rls/layui.js"></script>
<script src="http://oss.suyaqi.cn/static/crypto-js/crypto-js.js"></script>
<script>
layui.use(['jquery', 'form', 'layer'], function(){
	var $ = layui.jquery,
		form = layui.form(),
		layer = layui.layer;

	$('#code').click(function() {
		this.src = '<?= url('login/code') ?>' + '?t=' + Math.random();
	});

	form.on('submit(login)', function(data) {
		data.field.password = CryptoJS.HmacSHA256(data.field.account, data.field.password).toString();
		data.field.password = CryptoJS.HmacSHA256(data.field.password, data.field.code).toString();
		$.post(location.href, data.field, function(data) {
			if (data.stat === 0) {
				layer.msg(data.msg, {icon: 1, shade: 0.3, time: 1000});
				location.href = '<?= url('index/index'); ?>';
			} else {
				layer.msg(data.msg, {icon: 2, shade: 0.3, time: 1000});
			}
		}, 'json');
		
		return false;
	});

	form.verify({
		account: function(value) {
			if (!/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/.test(value)) {
				return '用户名格式错误';
			}
		},
		password: function(value) {
			if (!/^\w{6,18}$/.test(value)) {
				return '密码格式错误';
			}
		},
		code: function(value) {
			if (!/^\d{1,3}$/.test(value)) {
				return '验证码格式错误';
			}
		}
	});
});
</script>
</html>