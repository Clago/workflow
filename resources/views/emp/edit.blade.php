@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>编辑员工</h3>
        <form action="{{route('emp.update',['id'=>$emp->id])}}" method="POST">
          <div class="form-group">
            <label for="name">姓名</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="姓名" required value="{{$emp->name}}">
          </div>

          <div class="form-group">
            <label>邮箱</label>
            <input type="email" class="form-control"  name="email" placeholder="邮箱" required value="{{$emp->email}}">
          </div>

          <div class="form-group">
            <label>工号</label>
            <input type="text" class="form-control"  name="workno" placeholder="工号" required value="{{$emp->workno}}">
          </div>

          <div class="form-group">
            <label>密码</label>
            <input type="text" class="form-control"  name="password" placeholder="为空不更新">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">部门</label>
            <select class="form-control" name="dept_id">
              <option value="0">无</option>
              @foreach($depts as $v)
              <option value="{{$v->id}}" @if($emp->dept_id==$v->id) selected="selected" @endif >{{$v->dept_name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">离职</label>
            <label class="radio-inline">
            <input type="radio" name="leave"  value="1" @if($emp->leave==1) checked @endif> 是
            </label>
            <label class="radio-inline">
            <input type="radio" name="leave" value="0" @if($emp->leave==0) checked @endif> 否
            </label>
          </div>

          {{csrf_field()}}
          {{method_field('PUT')}}
          
          <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>
</div>
@endsection
