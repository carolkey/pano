<table class="layui-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>OSS对象名称</th>
        <th>缩略图</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $pano): ?>
    <tr>
        <td><?= $pano['id']; ?></td>
        <td id="<?= $pano['uuid']; ?>"><?= $pano['filename']; ?></td>
        <td><?= $pano['objname']; ?></td>
        <td>
            <a class="show-thumb" href="javascript:;" src="<?= $pano['thumb']; ?>">[查看]</a>
        </td>
        <td><?= $pano['create_time']; ?></td>
        <td>
            <a href="<?= $host . $pano['uuid']; ?>" target="_blank">[查看全景图]</a> /
            <a href="javascript:editName('<?= $pano['uuid']; ?>');">[编辑名称]</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div id="page"></div>
<script>
    layui.use(['laypage', 'jquery', 'layer'], function(){
        var laypage = layui.laypage,
            $ = layui.jquery,
            layer = layui.layer;
        laypage({
            cont: 'page',
            pages: <?= $pages; ?>,
            curr: <?= $curr; ?>,
            jump: function(obj, first) {
                if (!first) {
                    location.href = '/pano/panolist/page/' + obj.curr;
                }
            },
        });

        $('.show-thumb').on('click', function() {
            var src = $(this).attr('src');
            layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                shadeClose: true,
                area: ['240px', '240px'],
                content: '<img src="' + src +'">'
            });
        });

        window.editName = function(uuid) {
            layer.prompt({
                formType: 0,
                value: $('#' + uuid).text(),
                title: '请输入新名称',
            }, function(value, index, elem){
                $.post('<?= url('change-name') ?>', {
                    uuid: uuid,
                    name: value,
                }, function(res) {
                    layer.close(index);
                    layer.alert(res.msg);
                    if (res.stat == 0) {
                        $('#' + uuid).text(value)
                    }
                }, 'json');
            });
        }
    });
</script>