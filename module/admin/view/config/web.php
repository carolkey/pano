<fieldset class="layui-elem-field layui-field-title">
    <legend>站点设置</legend>
    <div class="layui-field-box">
        <div style="margin-bottom: 15px;">
            <input type="file" name="file" class="layui-upload-file" lay-title="上传LOGO（180 x 60）">
        </div>
        <form class="layui-form layui-form-pane" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label">站点名称</label>
                <div class="layui-input-block">
                    <input type="text" name="title" value="<?= $title ?>" placeholder="如：小黑屋" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">站点热词</label>
                <div class="layui-input-block">
                    <input type="text" name="keywords" value="<?= $keywords ?>" placeholder="如：小黑屋,博客,PHP" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">站点描述</label>
                <div class="layui-input-block">
                    <textarea name="description" placeholder="如：小黑屋是专门把人关小黑屋的工作室" class="layui-textarea noresize"><?= $description ?></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">版权信息</label>
                <div class="layui-input-block">
                    <input type="text" name="copyright" value="<?= htmlspecialchars($copyright) ?>" placeholder="如：Copyright © 2017 waaili.me" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">备案信息</label>
                <div class="layui-input-block">
                    <input type="text" name="icp" value="<?= $icp ?>" placeholder="如：闽ICP备15011128号" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <button class="layui-btn" lay-submit lay-filter="save">保存</button>
            </div>
        </form>
    </div>
</fieldset>
<script>
layui.use(['form', 'upload', 'jquery', 'layer'], function(){
    var form = layui.form(),
        $ = layui.jquery,
        layer = layui.layer;

    layui.upload({
        url: '<?= url('config/logo') ?>',
        before: function(input) {
            console.log(input);
            return false;
        },
        success: function(res){
            console.log(res);
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