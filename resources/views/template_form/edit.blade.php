@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>编辑表单控件</h3>
        <form action="{{route('template_form.update',['id'=>$template_form->id])}}" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label>控件名称</label>
            <input type="text" class="form-control"  name="field_name" placeholder="控件名称" value="{{$template_form->field_name}}">
          </div>

          <div class="form-group">
            <label>字段名</label>
            <input type="text" class="form-control"  name="field" placeholder="字段名" value="{{$template_form->field}}">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">字段类型</label>
            <select class="form-control" name="field_type">
              <option value="text" @if($template_form->field_type=='text') selected="selected" @endif >文本框</option>
              <option value="select" @if($template_form->field_type=='select') selected="selected" @endif>下拉框</option>
              <option value="radio" @if($template_form->field_type=='radio') selected="selected" @endif>单选</option>
              <option value="checkbox" @if($template_form->field_type=='checkbox') selected="selected" @endif>多选</option>
              <option value="textarea" @if($template_form->field_type=='textarea') selected="selected" @endif>多行文本框</option>
              <option value="date" @if($template_form->field_type=='date') selected="selected" @endif>日期</option>
               <option value="file" @if($template_form->field_type=='file') selected="selected" @endif>文件</option>
            </select>
          </div>

          <div class="form-group">
            <label>字段值</label>
            <textarea class="form-control"  name="field_value" placeholder="字段值"  rows="3">{{$template_form->field_value}}</textarea>
          </div>

          <div class="form-group">
            <label>默认值</label>
            <input type="text" class="form-control"  name="field_default_value" placeholder="默认值" value="{{$template_form->field_default_value}}">
          </div>

          <div class="form-group">
            <label>排序</label>
            <input type="text" class="form-control"  name="sort" placeholder="排序" value="50" value="{{$template_form->sort}}">
          </div>

          {{csrf_field()}}
          {{method_field('PUT')}}
          <button type="submit" class="btn btn-default">确定</button>
        </form>
    </div>
</div>
@endsection
