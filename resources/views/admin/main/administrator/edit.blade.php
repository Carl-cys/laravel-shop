<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>管理员修改</title>
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
            <form class="layui-form">
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="layui-form-item">
                    <label for="username" class="layui-form-label">
                        <span class="x-red">*</span>用户名
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="username" name="nickname" required="" lay-verify="required" value="{{ $user->nickname }}"
                        autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>将会成为您唯一的登入名
                    </div>
                </div>
                <!-- <div class="layui-form-item">
                    <label for="phone" class="layui-form-label">
                        <span class="x-red">*</span>手机
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="phone" value="18898551596"  lay-verify="phone"
                        autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>将会成为您唯一的登入名
                    </div>
                </div> -->
                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red">*</span>邮箱
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_email" name="email" required="" lay-verify="email" value="{{ $user->email }}"
                        autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="role" class="layui-form-label">
                        <span class="x-red">*</span>角色
                    </label>
                    <div class="layui-input-block">
                        @foreach($roles as $role)
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" title="{{ $role->name }}"
                        @if($myRoles->contains($role)) checked @endif >
                        @endforeach
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_pass" class="layui-form-label">
                        密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_pass" name="password" lay-verify="pass"  class="layui-input" placeholder="默认为不修改">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        6到16个字符
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                        确认密码
                    </label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_repass" lay-verify="repass" autocomplete="off" class="layui-input" placeholder="默认为不修改">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <input type="radio" name="status" value="1" title="启用" {{ $user->status == 1 ? 'checked' : '' }}>
                        <input type="radio" name="status" value="0" title="禁用" {{ $user->status == 0 ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                    </label>
                    <button  class="layui-btn" lay-filter="save" lay-submit="">
                        保存
                    </button>
                </div>
            </form>
        </div>
        <script src="{{ asset('templates/admin/lib/layui/layui.js') }}" charset="utf-8">
        </script>
        <script src="{{ asset('templates/admin/js/x-layui.js') }}" charset="utf-8">
        </script>
        <script>
            layui.use(['form','layer'], function(){
                $ = layui.jquery;
              var form = layui.form()
              ,layer = layui.layer;


              //自定义验证规则
              form.verify({
                nikename: function(value){
                  if(value.length < 5){
                    return '昵称至少得5个字符啊';
                  }
                }
                ,pass:function (value){
                      [/(.+){6,12}$/, '密码必须6到12位']
                  }
                ,repass: function(value){
                    if($('#L_pass').val()!=$('#L_repass').val()){
                        return '两次密码不一致';
                    }
                }
              });

              //监听提交
              form.on('submit(save)', function(data){
                // console.log(data);

                var arr = new Array();
                var a = $("input[name='roles[]']:checked")
                for (var i=0; i<a.length; i++) {
                    arr.push(a[i].value);
                }

                //发异步，把数据提交给php
                  $.ajax({
                      url:'{{ url('admin/adminlist/') }}' + '/'+ data.field.id,
                      type:'PUT',
                      datatype:'json',
                      data:{
                          'json_edit':JSON.stringify(data.field),
                          'roles':JSON.stringify(arr),
                          '_token':"{{ csrf_token() }}",
                      },
                      success:function (res){
                           res = JSON.parse(res);
                          if (res.success == '1') {
                              layer.alert(res.info, {icon: 6},function () {
                                  // 获得frame索引
                                  var index = parent.layer.getFrameIndex(window.name);
                                  //关闭当前frame
                                  parent.layer.close(index);
                              });

                          } else {
                              layer.alert("保存失败", {icon: 5},function () {
                                  // 获得frame索引
                                  var index = parent.layer.getFrameIndex(window.name);
                                  //关闭当前frame
                                  parent.layer.close(index);
                              });
                          }
                      }
                  });


                return false;
              });


            });
        </script>
    </body>

</html>
