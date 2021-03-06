@extends('admin.layouts.layout')
@section('style')
    <script src="{{asset('templates/admin/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('org/uploads/uploadsImg.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('org/uploadify/uploadify.css')}}">
    <style>
        .uploadify{ display: inline-block;}
        .uploadify-button{border:none;border-radius:5px;margin-top:8px;}
        .type-file-button{
            border-color: rgb(215, 215, 215);
            border-radius:0px 5px 5px 0px;
            color: rgb(255, 255, 255);
            display: inline-block;
            border-style: solid;
            vertical-align: top;
            border-width: 1px;
            border:none;
            width: 99px;
            height: 38px;
            background-color: #009688;;
        }
        .backclose{
            background:url({{asset('org/uploadify/uploadify-cancel.png')}});display: inline-block;height: 15px;width: 15px; position:relative;left: 95px;top:-36px;
        }
        /*table.add_tab */
    </style>
@endsection
@section('x-nav')
    <span class="layui-breadcrumb">
              <a><cite>首页</cite></a>
              <a><cite>添加分类</cite></a>
            </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"  href="javascript:location.replace(location.href);" title="刷新"><i class="layui-icon" style="line-height:30px">ဂ</i></a>
@endsection
@section('x-body')
    <form class="layui-form layui-form-pane"  action='' style="width:50%">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">
                    所在类别
                </label>
                <div class="layui-input-block">
                    <select lay-verify="required" name="pid">
                        <option value="">-请选择-</option>
                        <option value="0">顶级分类</option>
                        @foreach($cates as $v)
                            <option value="{{$v->id}}">{{$v->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">分类名称</label>
            <div class="layui-input-block">
                <input type="text" name="name"  lay-verify="required" placeholder="分类名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" >
            <div id="queue"></div>
            <div class="layui-form-item" >
                <label class="layui-form-label">图片</label>
                <div class="layui-input-inline" style="margin-left:30px;">
                    <input type="text" name="img" id="img" readonly autocomplete="off" class="layui-input">
                </div>
                <input id="file_upload"  type="file" multiple="true">

            </div>
            <div class="layui-form-item" id = 'thumbnail'>
                <label class="layui-form-label">缩略图
                </label>
                <div id='layer-photos-demo' class='layer-photos-demo' style='width: 660px;margin-left: 95px'>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width: 100px">商品标签</label>
            <div class="layui-input-block">
                @foreach($tags as $v)
                    <input name="tag_id[]" value="{{$v->tag_id}}" type="checkbox"  title="{{$v->tag_name}}">
                @endforeach
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <textarea name="describe" placeholder="请输入描述" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn"  lay-filter="add" lay-submit lay-filter="formDemo">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        {{csrf_field()}}
    </form>

@endsection
@section('js')
    {{--上传插件引入--}}
    <script>
        var token ='{{csrf_token()}}';
        var uploadPath = "{{url('admin/upload/category')}}"
        //实例化上传函数
        upload(uploadPath,token)
        //实例化删除函数
        delimg(uploadPath)
    </script>
    <script>
        layui.use(['form', 'layer', 'layedit', 'upload'], function () {
            $ = layui.jquery;
            var form = layui.form()
                , layer = layui.layer;

            var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
            $('#layer-photos-demo' ).on('click', function(){
                //图片放大
                layer.photos({
                    photos: '#layer-photos-demo',
                });
            });

            form.on('submit(add)', function(data){

                var a = $("input[name='tag_id[]']:checked");
                var arr = new Array();
                for(var i=0;i< a.length;i++){
                    arr[i] = $(a[i]).val();
                }

                //发异步，把数据提交给php
                $.ajax({
                    type: 'post',
                    url:  '/admin/goodscategory',
                    dataType: 'json',
                    data: { '_token':'{{csrf_token()}}',  'json': JSON.stringify(data.field),'tags':JSON.stringify(arr) },
                    success:function (data){
//                        console.log(data);
                        //失败
                        if(data.status == 1){
                            layer.msg(data.msg, {icon: 5,time:1000});
                        } else if(data.status == 3){
                            layer.msg(data.msg, {icon: 5,time:1000});
                        } else if(data.status == 4 ){
                            layer.msg(data.msg, {icon: 5,time:1000});
                        } else if(data.status == 0 ){
                            //成功
                            layer.alert(data.msg, {icon: 6},function () {
                                //获得frame索引
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
@endsection
