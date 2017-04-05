<form class="layui-form layui-form-pane" method="post">
    <blockquote class="layui-elem-quote">本系统使用阿里云OSS作为图床</blockquote>
    <div class="layui-form-item" pane>
        <label class="layui-form-label">OSS区域</label>
        <div class="layui-input-block">
            <?php foreach ($endpointList as $e): ?>
            <input type="radio" name="endpoint" value="<?= $e['id'] ?>" title="<?= $e['name'] ?>" <?= $e['id'] == $endpoint ? 'checked' : '' ?>>
            <?php endforeach; ?>
            <input type="checkbox" name="internal" value="1" title="内网" <?= $internal ? 'checked' : '' ?>>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">Bucket</label>
        <div class="layui-input-block">
            <input type="text" name="bucket" value="<?= $bucket ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">KeyID</label>
        <div class="layui-input-block">
            <input type="text" name="key_id" value="<?= $key_id ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">KeySecret</label>
        <div class="layui-input-block">
            <input type="text" name="key_secret" value="<?= $key_secret ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">CDN</label>
        <div class="layui-input-block">
            <input type="text" name="cdn" value="<?= $cdn ?>" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <button class="layui-btn" lay-submit lay-filter="save">保 存</button>
    </div>
</form>
<script>
layui.use(['form', 'jquery', 'layer'], function(){
    var form = layui.form(),
        $ = layui.jquery,
        layer = layui.layer;

    form.on('submit(save)', function(data) {
        if (data.field.internal == undefined) {
            data.field.internal = 0;
        }
        $.post(location.href, data.field, function(data) {
            layer.msg(data.msg, {icon: data.stat ? 2 : 1, shade: 0.3, time: 1000});
        }, 'json');
        return false;
    });
});
</script>