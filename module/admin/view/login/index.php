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
			width: 120px;
			border: none;
			outline: none;
			cursor: pointer;
		}
	</style>
</head>
<body style="background-color: #f1f1f1;">
	<div class="container">
		<form class="layui-form layui-form-pane">
			<div class="layui-form-item">
				<label class="layui-form-label">账号</label>
				<div class="layui-input-block">
					<input type="text" name="account" placeholder="输入账号" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">密码</label>
				<div class="layui-input-block">
					<input type="text" name="password" placeholder="输入密码" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">验证码</label>
				<div class="layui-input-block">
					<input type="text" name="code" placeholder="输入验证码" autocomplete="off" class="layui-input">
					<img id="code" src="<?= url('login/code') ?>" alt="code">
				</div>
			</div>
			<div class="layui-form-item">
				<button class="layui-btn" lay-submit style="width: 100%;">立 即 登 录</button>
			</div>
		</form>
	</div>
</body>
<script src="http://oss.suyaqi.cn/static/layui1.0.9rls/layui.js"></script>
<script>
layui.use(['jquery', 'form'], function(){
	var $ = layui.jquery;

	$('#code').click(function() {
		this.src = '<?= url('login/code') ?>' + '?t=' + Math.random();
	});
});
</script>
</html>