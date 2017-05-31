@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>编辑流程</h3>
        <form action="{{route('flow.update',['id'=>$flow->id])}}" method="POST">
          <div class="form-group">
            <label>流程名</label>
            <input type="text" class="form-control"  name="flow_name" placeholder="流程名称" value="{{$flow->flow_name}}">
          </div>

          <div class="form-group">
            <label>流程编号</label>
            <input type="text" class="form-control"  name="flow_no" placeholder="流程编号" value="{{$flow->flow_no}}">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">当前模板</label>
            <select class="form-control" name="template_id">
              <option value="0">无</option>
              @foreach($templates as $v)
              <option value="{{$v->id}}" @if($v->id==$flow->template_id) selected="selected" @endif>{{$v->template_name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">流程分类</label>
            <select class="form-control" name="type_id">
              @foreach($flow_types as $v)
              <option value="{{$v->id}}" @if($v->id==$flow->type_id) selected="selected" @endif>{{$v->type_name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">是否显示</label>
            <label class="radio-inline">
            <input type="radio" name="is_show"  value="1" @if($flow->is_show==1) checked @endif > 是
            </label>
            <label class="radio-inline">
            <input type="radio" name="is_show" value="0" @if($flow->is_show==0) checked @endif > 否
            </label>
          </div>

          {{csrf_field()}}
          {{method_field('PUT')}}
          <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>
</div>
@endsection
