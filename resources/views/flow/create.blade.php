@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>新建流程</h3>
        <form action="{{route('flow.store')}}" method="POST">
          <div class="form-group">
            <label>流程名</label>
            <input type="text" class="form-control"  name="flow_name" placeholder="流程名称">
          </div>

          <div class="form-group">
            <label>流程编号</label>
            <input type="text" class="form-control"  name="flow_no" placeholder="流程编号" >
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">当前模板</label>
            <select class="form-control" name="template_id">
              <option value="0">无</option>
              @foreach($templates as $v)
              <option value="{{$v->id}}">{{$v->template_name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">流程分类</label>
            <select class="form-control" name="template_id">
              @foreach($flow_types as $v)
              <option value="{{$v->id}}">{{$v->type_name}}</option>
              @endforeach
            </select>
          </div>
          
          <div class="form-group">
            <label for="exampleInputPassword1">是否显示</label>
            <label class="radio-inline">
            <input type="radio" name="is_show"  value="1"> 是
            </label>
            <label class="radio-inline">
            <input type="radio" name="is_show" value="0"> 否
            </label>
          </div>

          {{csrf_field()}}
          <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>
</div>
@endsection
