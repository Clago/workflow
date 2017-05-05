@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>添加部门</h3>
        <form action="{{route('dept.store')}}" method="POST">
          <div class="form-group">
            <label for="dept_name">部门名称</label>
            <input type="text" class="form-control" id="dept_name" name="dept_name" placeholder="部门名称" required>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">上级部门</label>
            <select class="form-control" name="pid">
              <option value="0">无</option>
              @foreach($depts as $v)
              <option value="{{$v->id}}">{{$v->dept_name}}</option>
              @endforeach
            </select>
          </div>
        
          <div class="form-group">
            <label for="exampleInputPassword1">部门主管</label>
            <select class="form-control" name="director_id">
              <option value="0">无</option>
              @foreach($emps as $v)
              <option value="{{$v->id}}">{{$v->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">部门经理</label>
            <select class="form-control" name="manager_id">
              <option value="0">无</option>
              @foreach($emps as $v)
              <option value="{{$v->id}}">{{$v->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="rank">排序</label>
            <input type="number" class="form-control" id="rank" name="rank" placeholder="排序" required>
          </div>

          {{csrf_field()}}
          
          <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>
</div>
@endsection
