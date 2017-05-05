@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="row">
          <p>
            <a class="btn btn-sm btn-primary" href="{{route('dept.create')}}">添加部门</a>
          </p>
          
          <div class="panel panel-info">
            <div class="panel-heading">部门列表</div>
  <!--           <div class="panel-body">
              
             </div> -->
             <table class="table table-bordered">
              <thead>
                  <tr>
                    <th>部门</th>
                    <th>部门主管</th>
                    <th>部门经理</th>
                    <th>创建时间</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($depts as $v)
                  <tr>
                    <td scope="row">
                     {{$v->html}}{{$v->dept_name}}
                    </td>
                    <td>
                      @if($v->director)
                      {{$v->director->name}}
                      @else
                      --
                      @endif
                    </td>
                    <td>
                      @if($v->manager)
                      {{$v->manager->name}}
                      @else
                      --
                      @endif
                    </td>
                    <td>{{$v->created_at}}</td>
                    <td>
                        <a href="{{route('dept.edit',['id'=>$v->id])}}" class="btn btn-info btn-xs">编辑</a>
                        <a href="javascript:;" data-href="{{route('dept.destroy',['id'=>$v->id])}}" class="btn btn-danger btn-xs delete">删除</a>
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
