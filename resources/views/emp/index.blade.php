@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <p>
            <a class="btn btn-sm btn-primary" href="{{route('emp.create')}}">添加员工</a>
        </p>
        <div class="row">
         <div class="panel panel-info">
            <div class="panel-heading">员工列表</div>
  <!--           <div class="panel-body">
              
             </div> -->
             <table class="table table-bordered">
              <thead>
                  <tr>
                    <th>姓名</th>
                    <th>部门</th>
                    <th>邮箱</th>
                    <th>是否离职</th>
                    <th>创建时间</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($emps as $v)
                  <tr>
                    <td scope="row">{{$v->name}}</td>
                    <td>
                      @if($v->dept)
                      {{$v->dept->dept_name}}
                      @else
                      暂无部门
                      @endif
                    </td>
                    <td>{{$v->email}}</td>
                    <td>
                      {{$v->leave?'离职':'在职'}}
                    </td>
                    <td>{{$v->created_at}}</td>
                    <td>
                        <a href="{{route('emp.edit',['id'=>$v->id])}}" class="btn btn-info btn-xs">编辑</a>
                        <a href="javascript:;" data-href="{{route('emp.destroy',['id'=>$v->id])}}" class="btn btn-danger btn-xs delete">删除</a>
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
