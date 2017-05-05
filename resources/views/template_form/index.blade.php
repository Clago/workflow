@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <p>
            <a class="btn btn-sm btn-primary" href="{{route('template_form.create',['template_id'=>Request::get('template_id')])}}">添加表单控件</a>
        </p>
        <div class="row">
         <div class="panel panel-info">
            <div class="panel-heading">【{{$template->template_name}}模板】表单控件列表</div>
  <!--           <div class="panel-body">
              
             </div> -->
             <table class="table table-bordered">
              <thead>
                  <tr>
                    <th>控件名称</th>
                    <th>字段名</th>
                    <th>字段类型</th>
                    <th>模板名称</th>
                    <th>排序</th>
                    <th>创建时间</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($template_forms as $v)
                  <tr>
                    <td>
                      {{$v->field_name}}
                    </td>
                    <td>{{$v->field}}</td>
                    <td>{{$v->field_type}}</td>
                    <td>{{$v->template->template_name}}</td>
                    <td>{{$v->sort}}</td>
                    <td>{{$v->created_at}}</td>
                    <td>
                        <a href="{{route('template_form.edit',['id'=>$v->id])}}" class="btn btn-info btn-xs">编辑</a>
                        <a href="javascript:;" data-href="{{route('template_form.destroy',['id'=>$v->id])}}" class="btn btn-danger btn-xs delete">删除</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
      </div>
    </div>
</div>
@endsection
