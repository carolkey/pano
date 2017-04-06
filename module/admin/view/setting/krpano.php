<form class="layui-form layui-form-pane" method="post">
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">krpano注册码</label>
        <div class="layui-input-block">
            <textarea name="code" placeholder="请填写krpano注册码" class="layui-textarea" style="resize: none;"><?= $code; ?></textarea>
        </div>
    </div>
    <div class="layui-form-item" pane>
        <label class="layui-form-label">操作系统</label>
        <div class="layui-input-block">
            <input type="radio" name="os" value="1" title="Windows x86" <?= empty($os) || $os == 1 ? 'checked' : ''; ?>>
            <input type="radio" name="os" value="2" title="Windows x64" <?= $os == 2 ? 'checked' : ''; ?>>
            <input type="radio" name="os" value="3" title="Linux x86" <?= $os == 3 ? 'checked' : ''; ?>>
            <input type="radio" name="os" value="4" title="Linux x64" <?= $os == 4 ? 'checked' : ''; ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <button class="layui-btn" lay-submit lay-filter="save">保存并注册</button>
    </div>
</form>
<pre class="layui-code" lay-title="注册信息"><?= $register; ?></pre>
<script>
    layui.use(['form', 'code', 'jquery'], function(){
        var form = layui.form(),
            $ = layui.jquery;

        form.on('submit(save)', function(data) {
            $.post(location.href, data.field, function(data) {
                if (data.stat === 0) {
                    $('.layui-code').text(data.info);
                    layui.code({
                        about:false,
                    });
                }
                layer.msg(data.msg, {icon: data.stat ? 2 : 1, shade: 0.3, time: 1000});
            }, 'json');
            return false;
        });

        layui.code({
            about:false,
        });
    });
</script>