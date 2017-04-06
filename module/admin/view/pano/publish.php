<link rel="stylesheet" href="/static/backend/css/publish.css">
<blockquote class="layui-elem-quote">全景图宽高比应为2:1</blockquote>
<!-- 错误信息 -->
<pre id="console"></pre>
<!-- 文件列表 -->
<table id="filelist" class="layui-table" lay-skin="nob">
    <colgroup>
        <col width="50">
        <col>
        <col width="50">
    </colgroup>
</table>
<!-- 选择按钮 -->
<div id="container">
    <button id="browse">选择文件</button>
</div>
<!-- 选择按钮 -->
<div class="select-btn">
    <input type="file" id="choose" multiple="multiple" accept="image/jpeg">
    <span><i class="layui-icon">&#xe61f;</i></span>
</div>
<!-- 上传按钮 -->
<button class="layui-btn" id="publish">立即生成</button>

<script src="/static/plupload/plupload.full.min.js"></script>
<script src="/static/plupload/i18n/zh_CN.js"></script>
<script>
    layui.use(['form', 'jquery', 'layer', 'element'], function(){
        var form = layui.form(),
            $ = layui.jquery,
            layer = layui.layer,
            element = layui.element();

        var ossImg = [];

        var oss = {
            tmpName: null,
            tmpHost: null,
            tmpKey: null,
            suffix: function(filename) {
                var pos = filename.lastIndexOf('.');
                return pos == -1 ? '' : filename.substring(pos);
            },
            randomName: function(filename) {
                var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
                for (var i = 0, str = '', maxPos = chars.length; i < 5; i++) {
                    str += chars.charAt(Math.floor(Math.random() * maxPos));
                }
                return new Date().getTime() + str + this.suffix(filename);
            },
            setMultipartParams: function(up, file) {
                $.ajax({
                    url: '<?= url('signature'); ?>',
                    async: false,
                    dataType: 'json',
                    success: function(data, textStatus) {
                        oss.tmpHost = data.host;
                        oss.tmpName = oss.randomName(file.name);
                        oss.tmpKey = data.prefix + oss.tmpName;
                        up.setOption({
                            'url': oss.tmpHost,
                            'multipart_params': {
                                'key': oss.tmpKey,
                                'policy': data.policy,
                                'OSSAccessKeyId': data.accessKeyId,
                                'success_action_status': '200',
                                'signature': data.signature,
                            },
                        });
                    },
                });
            },
            checkSize: function (file) {
                if (file.type == 'image/jpeg') {
                    var obj = window.URL || window.webkitURL;
                    var url = obj.createObjectURL(file);
                    var image = new Image();
                    image.src = url;
                    image.onload = function() {
                        if (image.naturalWidth == image.naturalHeight * 2) {
                            uploader.addFile(file);
                        } else {
                            oss.console('文件 [' + file.name + '] 的宽高比不是2:1');
                        }
                        obj.revokeObjectURL(url);
                    }
                } else {
                    oss.console('文件 [' + file.name + '] 不是JPG文件');
                }
            },
            console: function (msg) {
                $('#console').prepend('[root@lying ~] ' + msg + "\n");
            },
            process: function() {
                if (ossImg.length == 0) {
                    this.console('没有任何文件被上传');
                } else {
                    $.ajax({
                        url: '<?= url('process'); ?>',
                        async: false,
                        dataType: 'json',
                        type: 'POST',
                        data: {images: ossImg},
                        success: function(data, textStatus) {
                            console.log(data);
                        },
                    });
                }
            },
        };

        var uploader = new plupload.Uploader({
            browse_button: 'browse',
            url: 'http://oss.aliyuncs.com',
            filters: {
                mime_types: [
                    {title: 'JPG文件', extensions: 'jpg'},
                ],
                max_file_size: '1500mb',
                prevent_duplicates: true,
            },
            multi_selection: true,
            flash_swf_url: '/static/plupload/Moxie.swf',
            silverlight_xap_url: '/static/plupload/Moxie.xap',
            init: {
                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        var html = '<tr>'
                            + '<td class="layui-elip">' + file.name + '</td>'
                            + '<td>'
                            + '<div class="layui-progress" lay-showPercent="yes" lay-filter="' + file.id + '">'
                            + '<div class="layui-progress-bar" lay-percent="0%"></div>'
                            + '</div>'
                            + '</td>'
                            + '<td><a href="javascript:;" class="remove-list" id="' + file.id + '"><i class="layui-icon">&#x1007;</i></a></td>'
                            + '</tr>';
                        $('#filelist').append(html);
                        element.init();
                        oss.console('文件 [' + file.name + '] 加入队列');
                    });
                },
                FilesRemoved: function(up, files) {
                    plupload.each(files, function(file) {
                        $('#' + file.id).parentsUntil('tr').parent().remove();
                        oss.console('文件 [' + file.name + '] 移出队列');
                    });
                },
                BeforeUpload: function(up, file) {
                    oss.setMultipartParams(up, file);
                },
                FileUploaded: function(up, file, result) {
                    if (result.status == 200) {
                        ossImg.push({
                            host: oss.tmpHost,
                            name: oss.tmpName,
                            key: oss.tmpKey,
                        });
                        oss.console('文件 [' + file.name + ']（' + oss.tmpName + '）上传成功');
                    } else {
                        oss.console('文件 [' + file.name + ']（' + oss.tmpName + '）上传失败');
                    }
                },
                UploadFile: function(up, file) {
                    oss.console('文件 [' + file.name + '] 开始上传');
                },
                UploadProgress: function(up, file) {
                    element.progress(file.id, file.percent + '%');
                },
                UploadComplete: function(up, files) {
                    oss.console('所有文件上传成功');
                    oss.process();
                },
                Error: function(up, err) {
                    oss.console('错误' + err.code + '：' + err.message);
                },
            },
        });
        uploader.init();

        //上传按钮
        $('#publish').on('click', function() {
            uploader.start();
        });

        //选择文件，可以判断图片文件尺寸
        $('#choose').on('change', function() {
            for (var i = 0, len = this.files.length; i < len; i++) {
                oss.checkSize(this.files[i]);
            }
            this.value = '';
        });

        //未开始上传的时候，把文件从列表移除
        $(document).on('click', '.remove-list', function() {
            uploader.removeFile(uploader.getFile(this.id));
        });
    });
</script>