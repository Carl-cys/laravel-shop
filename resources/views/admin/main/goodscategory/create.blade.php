@extends('admin.layouts.layout')
@section('style')
    <script src="{{asset('templates/admin/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('org/uploadify/uploadify.css')}}">
    <style>
        .uploadify{ display: inline-block;}
        .uploadify-button{border:none;border-radius:5px;margin-top:8px;}
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
    <form class="layui-form layui-form-pane" action="{{url('admin/goodscategory')}}" method="post"  enctype="multipart/form-data" style="width:50%">
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
                <input type="text" name="name" required  lay-verify="required" placeholder="分类名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div id="queue"></div>
            <div class="layui-form-item">
                <label class="layui-form-label">图片</label>
                <div class="layui-input-inline">
                    <input type="text" name="img" autocomplete="off" class="layui-input">
                </div>
                <input id="file_upload"  type="file" multiple="true">
                <script type="text/javascript">
                    <?php 
                        $timestamp = time();
                      ?>
                    $(function() {
                        $('#file_upload').uploadify({
                            'buttonText' : '图片上传',
                            'formData'     : {
                                'timestamp' : '<?php
                                    echo $timestamp;
                                              ?>',
                                '_token'     : "{{csrf_token()}}"
                            },
                            'swf'      : "/org/uploadify/uploadify.swf",
                            //请求路径
                            'uploader' : "{{url('admin/upload')}}",
                            //成功返回回调函数
                            'onUploadSuccess' : function(file, data, response) {
                                //将目录的路径加到img中
                                $('input[name=img]').val(data);
                                //缩略图
                                $('#thumbnail').attr('src',data);//根目录下找
                            }
                        });
                    });
                </script>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">缩略图
                </label>
                <img id="thumbnail"  src="" alt="" style="max-height: 200px;max-width: 200px">
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <textarea name="describe" placeholder="请输入描述" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        {{csrf_field()}}
    </form>

@endsection
@section('js')
    <script>
        layui.use(['form', 'layer', 'layedit', 'upload'], function () {
            $ = layui.jquery;
            var form = layui.form()
                , layer = layui.layer
                , layedit = layui.layedit;
        });
    </script>
@endsection
