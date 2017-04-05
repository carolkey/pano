<div style="margin-bottom: 15px;">
    <input type="file" name="logo" class="layui-upload-file" lay-title="上传LOGO（180 x 60）">
</div>
<form class="layui-form layui-form-pane" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label">站点名称</label>
        <div class="layui-input-block">
            <input type="text" name="title" value="<?= $title ?>" placeholder="请输入站点名称" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">站点热词</label>
        <div class="layui-input-block">
            <input type="text" name="keywords" value="<?= $keywords ?>" placeholder="请输入站点关键词,用英文逗号隔开" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">站点描述</label>
        <div class="layui-input-block">
            <textarea name="description" placeholder="请输入站点描述" class="layui-textarea" style="resize: none;"><?= $description ?></textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">版权信息</label>
        <div class="layui-input-block">
            <input type="text" name="copyright" value="<?= htmlspecialchars($copyright) ?>" placeholder="请输入站点版权信息，可以为html标签" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">备案信息</label>
        <div class="layui-input-block">
            <input type="text" name="icp" value="<?= $icp ?>" placeholder="请输入备案号" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <button class="layui-btn" lay-submit lay-filter="save">保 存</button>
    </div>
</form>
<script>
layui.use(['form', 'upload', 'jquery', 'layer'], function(){
    var form = layui.form(),
        $ = layui.jquery,
        layer = layui.layer;

    layui.upload({
        url: '<?= url('config/logo') ?>',
        before: function(input) {
            layer.load(1, {shade: 0.1});
        },
        success: function(res){
            layer.closeAll('loading');
            layer.msg(res.msg, {icon: res.stat ? 2 : 1, shade: 0.3, time: 1000});
        }
    });

    form.on('submit(save)', function(data) {
        $.post(location.href, data.field, function(data) {
            layer.msg(data.msg, {icon: data.stat ? 2 : 1, shade: 0.3, time: 1000});
        }, 'json');
        return false;
    });
});
</script>