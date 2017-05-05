@extends('layouts.app')

@section('content')
<div class="container">
    <p>
        <a class="btn btn-sm btn-primary" href="{{route('flow.create')}}">创建流程</a>
    </p>
    <div class="row">
        <div class="row">
         <div class="panel panel-info">
            <div class="panel-heading">工作流列表</div>
  <!--           <div class="panel-body">
              
             </div> -->
             <table class="table table-bordered">
              <thead>
                  <tr>
                    <th>流程名称</th>
                    <th>模板名称</th>
                    <th>状态</th>
                    <th>创建时间</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($flows as $v)
                  <tr>
                    <td scope="row">{{$v->flow_name}}</td>
                    <td>
                      {{$v->template?$v->template->template_name:'暂无模板'}}
                    </td>
                    <td>
                      {{$v->is_publish?'已发布':'未发布'}}
                    </td>
                    <td>{{$v->created_at}}</td>
                    <td>
                        <a href="/flow/flowchart/{{$v->id}}" class="btn btn-info btn-xs">流程图</a>
                        <a href="{{route('flow.edit',['id'=>$v->id])}}" class="btn btn-primary btn-xs">编辑</a>
                        <a href="javascript:;" data-href="{{route('flow.destroy',['id'=>$v->id])}}" class="btn btn-danger btn-xs delete">删除</a>
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
