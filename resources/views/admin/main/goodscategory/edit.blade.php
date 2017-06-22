@extends('admin.layouts.layout')
@section('style')
     <script src="{{asset('templates/admin/js/jquery.min.js')}}" type="text/javascript"></script>
     <script src="{{asset('org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
     <link rel="stylesheet" type="text/css" href="{{asset('org/uploadify/uploadify.css')}}">
     <script src="{{asset('org/uploads/uploadsImg.js')}}" type="text/javascript"></script>
{{--     <script src="{{asset('org/uploads/uploadsImg.css')}}" type="text/javascript"></script>--}}
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
    </style>
@endsection
@section('x-body')
    <form class="layui-form layui-form-pane" action="" method="post"  enctype="multipart/form-data" style="width:50%">
        {{--{{csrf_field()}}--}}
        {{--{{ method_field('PUT') }}--}}
        <input type="hidden" value="{{$info->id}}" name="id">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">
                    所在类别
                </label>
                <div class="layui-input-block">
                    <select lay-verify="required" name="pid">
                        <option value="0">顶级分类</option>
                        @foreach($cates as $v)
                            <option value="{{$v->id}}"  @if( $info->pid == $v->id )  selected @endif>{{$v->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">分类名称</label>
            <div class="layui-input-block">
                <input type="text" value='{{$info->name}}' name="name" required  lay-verify="required" placeholder="分类名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item" >
            <div id="queue"></div>
            <div class="layui-form-item" >
                <label class="layui-form-label">图片</label>
                <div class="layui-input-inline" style="margin-left:30px;">
                    <input type="text" value='{{$info->img}}' name="img" id="img" autocomplete="off" class="layui-input">
                </div>
                <input id="file_upload"  type="file" multiple="true">

            </div>
            <div class="layui-form-item" id = 'thumbnail'>
                <label class="layui-form-label">缩略图
                </label>
                <div id='layer-photos-demo' class='layer-photos-demo' style='width: 660px;'>
                    {{--<img id="thumbnail"  src="@if(!empty($img)) {{$img}} @endif" alt="" style="max-height: 200px;max-width: 200px">--}}
                </div>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-block">
                <textarea name="describe" placeholder="请输入描述" class="layui-textarea">{{$info->describe}}</textarea>
            </div>
        </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button  class="layui-btn" lay-filter="save" lay-submit="">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
    </form>

@endsection
@section('js')
    <script>
        layui.use(['form', 'layer', 'upload'], function () {
            $ = layui.jquery;
            var form = layui.form()
                , layer = layui.layer
                , layedit = layui.layedit;
            form.on('submit(save)', function(data){
//            console.log(data);
                //发异步，把数据提交给php
                {{--var url = '{{url('admin/goodscategory/')}}'+'/'+data.field.id;--}}
                $.ajax({
                    type: 'post',
                    url:  "/admin/goodscategory/"+data.field.id,
                    dataType: 'json',
                    data: {
                        '_token':'{{csrf_token()}}',
                        '_method': 'PUT',
                        'name': data.field.name,
                        'describe': data.field.describe,
                        'pid' :data.field.pid,
                        'img' : data.field.img,
                    },
                    success:function (data){
                        if(data == 1){
                            layer.alert("保存成功", {icon: 6},function () {
                                // 获得frame索引
                                var index = parent.layer.getFrameIndex(window.name);
                                //关闭当前frame
                                parent.layer.close(index);
                            });
                        } else {
                            layer.msg('保存失败啦！稍后再试', {icon: 5});
                        }

                    }
                });

                return false;
            });

        });

        var token ='{{csrf_token()}}';
        var uploadPath = "{{url('admin/upload/category')}}"
            // 实例化上传函数
             upload(uploadPath,token)
           //实例化删除函数
              delimg(uploadPath)
    </script>
@endsection