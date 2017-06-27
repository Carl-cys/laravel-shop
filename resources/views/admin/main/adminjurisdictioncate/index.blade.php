<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>权限分类</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="{{ asset('templates/admin/css/x-admin.css') }}" media="all">
    </head>
    <body>
        <div class="x-nav">
            <span class="layui-breadcrumb">
              <a><cite>首页</cite></a>
              <a><cite>分类管理</cite></a>
              <a><cite>权限分类</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
        </div>
        <div class="x-body">
            <form class="layui-form x-center" action="" style="width:40%">
                <div class="layui-form-pane" style="margin-top: 15px;">
                  <div class="layui-form-item">
                    <label class="layui-form-label">分类名</label>
                    <div class="layui-input-inline">
                      <input type="text" name="class_name"  placeholder="分类名" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-input-inline" style="width:80px">
                        <button class="layui-btn"  lay-submit="" lay-filter="*"><i class="layui-icon">&#xe608;</i>添加</button>
                    </div>
                  </div>
                </div> 
            </form>
            <xblock><button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon">&#xe640;</i>批量删除</button><span class="x-right" style="line-height:40px">共有数据：{{ $num }} 条</span></xblock>
            <table class="layui-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="" value="">
                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            分类名
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody id="x-link">

                @if(count($class) > 0)
                @foreach($class as $row)

                    <tr>
                        <td>
                            <input type="checkbox" value="{{ $row->id }}" name="id">
                        </td>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->class_name }}</td>
                        <td class="td-manage">
                            <a title="编辑" href="javascript:;" onclick="cate_edit('编辑','{{url('admin/adminjurisdiction/'.$row->id.'/edit')}}','{{ $row->id }}','','510')"
                            class="ml-5" style="text-decoration:none">
                                <i class="layui-icon">&#xe642;</i>
                            </a>
                            <a title="删除" href="javascript:;" onclick="cate_del(this,{{ $row->id }})"
                            style="text-decoration:none">
                                <i class="layui-icon">&#xe640;</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="4" ><h3 style="text-align: center">暂无分类信息</h3></td>
                    </tr>
                @endif

                </tbody>
            </table>

            <div id="page"></div>
        </div>
        <script src="{{ asset('templates/admin/lib/layui/layui.js') }}" charset="utf-8"></script>
        <script src="{{ asset('templates/admin/js/x-layui.js') }}" charset="utf-8"></script>
        <script>
            layui.use(['element','laypage','layer','form'], function(){
                $ = layui.jquery;//jquery
              lement = layui.element();//面包导航
              laypage = layui.laypage;//分页
              layer = layui.layer;//弹出层
              form = layui.form();//弹出层

              //监听提交
              form.on('submit(*)', function(data){
//                console.log(data);
                //发异步，把数据提交给php
                  $.ajax({
                      url:'{{ url('admin/adminjurisdiction') }}',
                      type:'post',
                      datatype:'json',
                      data:{
                          'class_name':data.field.class_name,
                          '_token':"{{ csrf_token() }}"
                      },
                      success:function (data){
                          data = JSON.parse(data);

                          if (data.success == '1') {


                              layer.alert("增加成功", {icon: 6});

                              var str = '<tr><td>';
                                  str += '<input type="checkbox"value="'+ data.id +'"name=""></td>';
                                  str += '<td>'+ data.id +'</td>';
                                  str += '<td>'+data.class_name+'</td>';
                                  str += '<td class="td-manage">';
                                  str += '<a title="编辑"href="javascript:;"onclick="cate_edit(\'编辑\',\'{{ url('admin/adminjurisdiction/') }}'+ '/' + data.id +'/edit\',\''+ data.id +'\',\'\',\'510\')"class="ml-5"style="text-decoration:none">';
                                  str += '<i class="layui-icon">&#xe642;</i></a>';
                                  str += '<a title="删除"href="javascript:;"onclick="cate_del(this,\''+ data.id +'\')"style="text-decoration:none"><i class="layui-icon">&#xe640;</i></a></td></tr>';

                              $('#x-link').prepend(''+ str +'');

                          }
                      }
                  });

                return false;
              });
            })

              //以上模块根据需要引入

            //批量删除提交
             function delAll () {
                layer.confirm('确认要删除吗？',function(index){
                    //捉到所有被选中的，发异步进行删除
                    layer.msg('删除成功', {icon: 1});
                });
             }
            
            

            //-编辑
            function cate_edit (title,url,id,w,h) {
                x_admin_show(title,url,w,h); 
            }
            
            /*删除*/
            function cate_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){

                    //发异步删除数据
                    $.ajax({
                        url:'{{'adminjurisdiction'}}' + '/' + id,
                        type:'delete',
                        datatype:'json',
                        data:{'_token':"{{ csrf_token() }}", 'id':id},
                        success:function (data){
                            if (data == '1') {
                                $(obj).parents("tr").remove();
                                layer.msg('已删除!',{icon:1,time:1000});
                            } else {
                                layer.msg('删除失败!',{icon:5,time:1000});
                            }
                        }
                    });

                });
            }
            </script>

    </body>
</html>