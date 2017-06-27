<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>角色权限修改</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="{{ asset('templates/admin/css/x-admin.css') }}" media="all">
    </head>

    <body>
        <div class="x-body">
            <form action="" method="post" class="layui-form layui-form-pane">
                <input type="hidden" name="id" value="1">
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="display_name" required="" lay-verify="required" value="1"
                               autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="name" class="layui-form-label">
                        <span class="x-red">*</span>角色标识
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="name" required="" lay-verify="required" value="1"
                               autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">
                        拥有权限
                    </label>
                    <table  class="layui-table layui-input-block" >
                        <tbody>
                            <tr>
                                <td>
                                    用户管理
                                </td>
                                <td>
                                    <div class="layui-input-block">


                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    文章管理
                                </td>
                                <td>
                                    <div class="layui-input-block">
                                        <input name="permission[]" type="checkbox" value="2"> 文章添加
                                        <input name="permission[]" checked="" type="checkbox" value="2"> 文章删除
                                        <input name="permission[]" type="checkbox" value="2"> 文章修改
                                        <input name="permission[]" checked="" type="checkbox" value="2"> 文章改密
                                        <input name="permission[]" type="checkbox" value="2"> 文章列表
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label for="desc" class="layui-form-label">
                        描述
                    </label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" id="desc" name="description" class="layui-textarea">a</textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                <button class="layui-btn" lay-submit="" lay-filter="save">保存</button>
              </div>
            </form>
        </div>
        <script src="{{ asset('templates/admin/lib/layui/layui.js') }}" charset="utf-8"></script>
        <script src="{{ asset('templates/admin/js/x-layui.js') }}" charset="utf-8"></script>
        <script>
            layui.use(['form','layer'], function(){
                $ = layui.jquery;
              var form = layui.form()
              ,layer = layui.layer;

              //监听提交
              form.on('submit(save)', function(data){
                console.log(data);
                  var arr = new Array();
                  var a = $("input[name='permission[]']:checked")
                  for (var i=0; i<a.length; i++) {
                      arr.push(a[i].value);
                  }
                //发异步，把数据提交给php
                $.ajax({
                  url:'{{ url('admin/adminrole/')}}'+ '/' + data.field.id,
                  type:'PUT',
                  datatype:'json',
                  data:{
                    '_token':"{{ csrf_token()}}",
                    'json':JSON.stringify(data.field),
                    'perms':JSON.stringify(arr),
                  },
                  traditional: true,
                  success:function (data){
                      console.log(data);
                  }

                });
                layer.alert("增加成功", {icon: 6},function () {
                    // 获得frame索引
                    var index = parent.layer.getFrameIndex(window.name);
                    //关闭当前frame
                    parent.layer.close(index);
                });
                return false;
              });


            });
        </script>

    </body>

</html>
