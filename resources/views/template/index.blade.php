@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <p>
            <a class="btn btn-sm btn-primary" href="{{route('template.create')}}">添加模板</a>
        </p>
        <div class="row">
         <div class="panel panel-info">
            <div class="panel-heading">模板列表</div>
  <!--           <div class="panel-body">
              
             </div> -->
             <table class="table table-bordered">
              <thead>
                  <tr>
                    <th>模板名称</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($templates as $v)
                  <tr>
                    <td scope="row">{{$v->template_name}}</td>
                    <td>{{$v->created_at}}</td>
                    <td>{{$v->updated_at}}</td>
                    <td>
                        <a href="{{route('template_form.index',['template_id'=>$v->id])}}" class="btn btn-info btn-xs">表单控件</a>
                        <a href="{{route('template.edit',['id'=>$v->id])}}" class="btn btn-info btn-xs">编辑</a>
                        <a href="javascript:;" data-href="{{route('template.destroy',['id'=>$v->id])}}" class="btn btn-danger btn-xs delete">删除</a>
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
